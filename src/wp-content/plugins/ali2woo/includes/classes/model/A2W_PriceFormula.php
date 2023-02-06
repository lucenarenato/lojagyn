<?php

/**
 * Description of A2W_PriceFormula
 *
 * @author Andrey
 */
class A2W_PriceFormula {

    public $id = 0;
    public $category = '';
    public $category_name = '';
    public $min_price = '';
    public $max_price = '';
    public $sign = '*';
    public $value = '';
    public $compared_sign = '*';
    public $compared_value = '';
    public $discount1 = '';
    public $discount2 = '';

    public function __construct($data = 0) {
        if (is_int($data) && $data) {
            $this->id = $data;
            $this->load($this->id);
        } else if (is_array($data)) {
            foreach ($data as $field => $value) {
                if (property_exists(get_class($this), $field)) {
                    $this->$field = esc_attr($value);
                }
            }
        }
    }

    public function load($id = false) {
        $load_id = $id ? $id : ($this->id ? $this->id : 0);
        if ($load_id) {
            $formula_list = A2W_PriceFormula::load_formulas_list(false);
            foreach ($formula_list as $formula) {
                if (intval($formula['id']) === intval($load_id)) {
                    foreach ($formula as $field => $value) {
                        if (property_exists(get_class($this), $field)) {
                            $this->$field = esc_attr($value);
                        }
                    }
                    break;
                }
            }
        }
        return $this;
    }

    public function save() {
        $formula_list = A2W_PriceFormula::load_formulas_list(false);

        if (!intval($this->id)) {
            $this->id = 1;
            foreach ($formula_list as $key => $formula) {
                if (intval($formula['id']) >= $this->id) {
                    $this->id = intval($formula['id']) + 1;
                }
            }
            $formula_list[] = get_object_vars($this);
        } else {
            $boolean = false;
            foreach ($formula_list as $key => $formula) {
                if (intval($formula['id']) === intval($this->id)) {
                    $formula_list[$key] = get_object_vars($this);
                    $boolean = true;
                }
            }
            if (!$boolean) {
                $formula_list[] = get_object_vars($this);
            }
        }

        a2w_set_setting('formula_list', array_values($formula_list));
        return $this;
    }

    public function delete() {
        $formula_list = A2W_PriceFormula::load_formulas_list(false);
        foreach ($formula_list as $key => $formula) {
            if (intval($formula['id']) === intval($this->id)) {
                unset($formula_list[$key]);
                a2w_set_setting('formula_list', array_values($formula_list));
            }
        }
    }

    public static function deleteAll() {
        a2w_del_setting('formula_list');
    }

    public static function normalize_product_price($product) {
        $product_price = 0;
        if (isset($product['price']) && floatval($product['price'])) {
            $product_price = floatval($product['price']);
        } else if (isset($product['price_min']) && floatval($product['price_min'])) {
            $product_price = floatval($product['price_min']);
        } else if (isset($product['price_max']) && floatval($product['price_max'])) {
            $product_price = floatval($product['price_max']);
        }
        return $product_price;
    }

    public static function apply_formula($product, $round = 2, $type = 'all') {
        $formula = A2W_PriceFormula::get_formula_by_product($product);

        $product_price = A2W_PriceFormula::normalize_product_price($product);
        
        if ($formula && $product_price) {
            $use_compared_price_markup = a2w_get_setting('use_compared_price_markup');
            $price_cents = a2w_get_setting('price_cents');
            $price_compared_cents = a2w_get_setting('price_compared_cents');
            
            if ($type === 'all' || $type === 'price' || !isset($product['calc_price'])) {
                if ($formula->sign == "=") {
                    $product['calc_price'] = round(floatval($formula->value), $round);
                } else if ($formula->sign == "*") {
                    $product['calc_price'] = round(floatval($product_price) * floatval($formula->value), $round);
                } else if ($formula->sign == "+") {
                    $product['calc_price'] = round(floatval($product_price) + floatval($formula->value), $round);
                }
                
                if(!empty($product['calc_price']) && $price_cents>-1){
                    $product['calc_price'] = round(floor($product['calc_price'])+($price_cents/100), 2);
                }
            }

            if ($type === 'all' || $type === 'regular_price' || !isset($product['calc_regular_price'])) {
                // use source discount
                if (isset($product['discount']) && isset($product['calc_price'])) {
                    $product['calc_regular_price'] = round($product['calc_price'] * 100 / (100 - intval($product['discount'])), $round);
                }

                if ($use_compared_price_markup) {
                    if ($formula->compared_sign == "=") {
                        $product['calc_regular_price'] = round(floatval($formula->compared_value), $round);
                    } else if ($formula->compared_sign == "*") {
                        $product['calc_regular_price'] = round(floatval($product_price) * floatval($formula->compared_value), $round);
                    } else if ($formula->compared_sign == "+") {
                        $product['calc_regular_price'] = round(floatval($product_price) + floatval($formula->compared_value), $round);
                    }
                }
                
                if(!empty($product['calc_regular_price']) && $price_compared_cents>-1){
                    $product['calc_regular_price'] = round(floor($product['calc_regular_price'])+($price_compared_cents/100), 2);
                }
            }

            if (isset($product['sku_products']['variations']) && $product['sku_products']['variations']) {
                foreach ($product['sku_products']['variations'] as &$var) {
                    $formula = A2W_PriceFormula::get_formula_by_product($var);
                    if ($formula) {
                        if ($type === 'all' || $type === 'price' || !isset($var['calc_price'])) {
                            if ($formula->sign == "=") {
                                $var['calc_price'] = round(floatval($formula->value), $round);
                            } else if ($formula->sign == "*") {
                                $var['calc_price'] = round(floatval($var['price']) * floatval($formula->value), $round);
                            } else if ($formula->sign == "+") {
                                $var['calc_price'] = round(floatval($var['price']) + floatval($formula->value), $round);
                            }
                            
                            if(!empty($var['calc_price']) && $price_cents>-1){
                                $var['calc_price'] = round(floor($var['calc_price'])+($price_cents/100), 2);
                            }
                        }

                        if ($type === 'all' || $type === 'regular_price' || !isset($var['calc_regular_price'])) {
                            // use source discount
                            if (intval($var['discount']) < 100) {
                                $var['calc_regular_price'] = round($var['calc_price'] * 100 / (100 - intval($var['discount'])), $round);
                            } else {
                                $var['calc_regular_price'] = $var['calc_price'];
                            }


                            $use_compared_price_markup = a2w_get_setting('use_compared_price_markup');
                            if ($use_compared_price_markup) {
                                if ($formula->compared_sign == "=") {
                                    $var['calc_regular_price'] = round(floatval($formula->compared_value), $round);
                                } else if ($formula->compared_sign == "*") {
                                    $var['calc_regular_price'] = round(floatval($var['price']) * floatval($formula->compared_value), $round);
                                } else if ($formula->compared_sign == "+") {
                                    $var['calc_regular_price'] = round(floatval($var['price']) + floatval($formula->compared_value), $round);
                                }
                            }
                            
                            if(!empty($var['calc_regular_price']) && $price_compared_cents>-1){
                                $var['calc_regular_price'] = round(floor($var['calc_regular_price'])+($price_compared_cents/100), 2);
                            }
                        }
                    }
                }
            }
        }



        return $product;
    }

    public static function load_formulas() {
        return A2W_PriceFormula::load_formulas_list(true);
    }

    private static function load_formulas_list($asObject = true) {
        $result = array();
        $formula_list = a2w_get_setting('formula_list');
        $formula_list = $formula_list && is_array($formula_list) ? $formula_list : array();
        if ($asObject) {
            foreach ($formula_list as $formula) {
                $fo = new A2W_PriceFormula();
                foreach ($formula as $name => $value) {
                    if (property_exists(get_class($fo), $name)) {
                        $fo->$name = $value;
                    }
                }
                $result[] = $fo;
            }
        } else {
            $result = $formula_list;
        }

        return $result;
    }

    public static function get_default_formula() {
        $formula = a2w_get_setting('default_formula');
        return new A2W_PriceFormula($formula && is_array($formula) ? $formula : array('value' => 1, 'sign' => '*', 'compared_value' => 1, 'compared_sign' => '*'));
    }

    public static function set_default_formula($formula) {
        a2w_set_setting('default_formula', get_object_vars($formula));
    }

    public static function get_default_formulas() {
        $f1 = new A2W_PriceFormula();
        $f1->id = 1;
        $f1->min_price = 0;
        $f1->max_price = 10;
        $f1->sign = "*";
        $f1->value = 1;

        $f2 = new A2W_PriceFormula();
        $f2->id = 1;
        $f2->min_price = 10.01;
        $f2->max_price = '';
        $f2->sign = "*";
        $f2->value = '';


        return array($f1, $f2);
    }

    public static function get_formula_by_product($product) {
        $res_formula = false;
        
        $use_extended_price_markup = a2w_get_setting('use_extended_price_markup');
        if ($use_extended_price_markup) {
            
            $product_price = A2W_PriceFormula::normalize_product_price($product);
            if($product_price){
                $formula_list = A2W_PriceFormula::load_formulas_list();
                foreach ($formula_list as $formula) {
                    $check = true;

                    if (isset($formula->min_price) && $formula->min_price && floatval($formula->min_price) > $product_price) {
                        $check = false;
                    }

                    if (isset($formula->max_price) && $formula->max_price && floatval($formula->max_price) < $product_price) {
                        $check = false;
                    }

                    if (isset($formula->category) && $formula->category && intval($formula->category) != intval($product['category_id'])) {
                        $check = false;
                    }

                    if ($check) {
                        $res_formula = $formula;
                        break;
                    }
                }    
            }else{
                error_log("can't find normalize_product_price for ".$product['id']);
            }
        }

        return $res_formula ? $res_formula : A2W_PriceFormula::get_default_formula();
    }
}
