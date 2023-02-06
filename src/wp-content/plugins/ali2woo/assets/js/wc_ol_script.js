var a2w_reload_page_after_ajax = false;
jQuery(function ($) {

    var get_id_from_link_anchor = function(el){
        var jq_el = $(el);
        
        if ( typeof jq_el.attr('id') == "undefined" && jq_el.attr('href').substr(0,1) == "#" ) var id = jq_el.attr('href').substr(1);
        else var id =  jq_el.attr('id').split('-')[1];    
        
        return id;
    }
    
	$(document).on("click", ".a2w-order-info", function () {
           
        var id = get_id_from_link_anchor(this);
        
		$.a2w_show_order(id);
		return false;
	});
    
    
    $(document).on("click", ".a2w-aliexpress-sync", function () {
        
        var item_sync_btn =  $(this);
        item_sync_btn.prop("disabled",true);   
       
        var ext_id = get_id_from_link_anchor(this);
        
        var item_info_btn = $(this).siblings('.a2w-order-info')[0], 
            id = get_id_from_link_anchor(item_info_btn); 
    

        var data = [ {'ext_order_id':ext_id}];
        
        if (typeof a2w_get_order_tracking_code !== "undefined") {            
            a2w_get_next_tracking_code(data, 0, 200, function(index, ext_id, tracking_codes, status){
              
                if (tracking_codes && tracking_codes.length>0){
                    item_sync_btn.hide();
                    a2w_save_tracking_code(id, tracking_codes, function(res){
                        
                                if (res !== null) {
                                    if (res.state == 'ok') {
                                        alert(a2w_script_data.lang.tracking_sync_done); 
                                    } else {
                                        alert(res.message);      
                                    }   
                                }
                                
                            });
                    
                } else {
                      if (status == 500) {
                        alert(a2w_script_data.lang.error_cant_do_tracking_sync);
                      } else if (status == 404){
                        alert(a2w_script_data.lang.error_didnt_do_find_alix_order_num+data.ext_order_id);    
                      } else if (status == 401){
                        alert(a2w_script_data.lang.error_cant_do_tracking_sync_login_to_account);    
                      } else if (status == 403) alert(a2w_script_data.lang.error_403_code+data.ext_order_id);
                      else {
                        alert(a2w_script_data.lang.no_tracking_codes_for_order);    
                      }
                      item_sync_btn.prop("disabled",false); 
                }
                    

            });
        } else {
              item_sync_btn.prop("disabled",false); 
              alert(a2w_script_data.lang.error_please_install_new_extension);
        }      
                
        return false;
    });

	$.a2w_show_order = function (id) {
		$('<div id="a2w-dialog' + id + '"></div>').dialog({
			dialogClass: 'a2w-dialog',
			modal: true,
                        width: "400px",
			title: a2w_script_data.lang.aliexpress_info + ": " + id,
			open: function () {
				$('#a2w-dialog' + id).html(a2w_script_data.lang.please_wait_data_loads);
				var data = {'action': 'a2w_order_info', 'id': id};

				$.post(ajaxurl, data, function (response) {
	
					var json = jQuery.parseJSON(response);
				

					if (json.state === 'error') {

						console.log(json);

					} else {
						$('#a2w-dialog' + json.data.id).html(json.data.content.join('<br/>'));
					}

				});


			},
			close: function (event, ui) {
				$("#a2w-dialog" + id).remove();
			},
			buttons: {
				Ok: function () {
					$(this).dialog("close");
				}
			}
		});

		return false;

	};
    
    var sync_btn =  $('#a2w_bulk_order_sync_manual');
    
    sync_btn.on('click', function(){
        
       sync_btn.prop("disabled",true);
        
        if (typeof a2w_get_order_tracking_code !== "undefined") { 
            sync_btn.val(a2w_script_data.lang.please_wait);
            a2w_get_fulfilled_orders(function(data){
            
                var cnt = data.length;
                sync_btn.val(a2w_script_data.lang.sync_process + ' 0/' + cnt + '...');
                
                if (cnt > 0 )
                    a2w_get_next_tracking_code(data, 0, 200, function(index, ext_id, tracking_codes, status){
                        
                        
                          if (status == 500) {
                              alert(a2w_script_data.lang.error_cant_do_tracking_sync);
                              
                              sync_btn.val(a2w_script_data.lang.tracking_sync);
                              sync_btn.prop("disabled",false);    
                                    
                              return false;
                          }
          
                          if (status == 404) console.log(a2w_script_data.lang.error_didnt_do_find_alix_order_num+data[index].ext_order_id);
          
                          if (status == 401) {
                              alert(a2w_script_data.lang.error_cant_do_tracking_sync_login_to_account);
                              
                              sync_btn.val(a2w_script_data.lang.tracking_sync);
                              sync_btn.prop("disabled",false)
                              
                              return false;
                          }
          
                          if (status == 403) console.log(a2w_script_data.lang.error_403_code+data[index].ext_order_id);
          
          
          
                          sync_btn.val(a2w_script_data.lang.sync_process + ' ' + (index+1) + '/' + cnt + '...'); 
                        
                        if ( index === cnt-1 ) {
                            sync_btn.val(a2w_script_data.lang.sync_done);
                            sync_btn.prop("disabled",false);
                        }
                        if (tracking_codes && tracking_codes.length>0){
                            a2w_save_tracking_code(data[index].order_id, tracking_codes, function(res){
                                
                                 if (res !== null) {
                                    if (res.state == 'error') {
                                        console.log(res.message); 
                                    }   
                                }
                                    
                            });
                        }
                            
               
                    });
                else {
                    sync_btn.val(a2w_script_data.lang.tracking_sync);
                    sync_btn.prop("disabled",false);   
                }
            
            }); 
         
        } else {
             sync_btn.val(a2w_script_data.lang.tracking_sync);
             alert(a2w_script_data.lang.error_please_install_new_extension);
        }
   
       
        return false;  
    });
    
    var a2w_get_next_tracking_code = function(data, i, status_code, callback_func){
    
          if ((status_code == 200 || status_code == 404 || status_code == 403) && i < data.length)   {
           
              a2w_get_order_tracking_code(data[i].ext_order_id, function( response){
                  
                callback_func(i, data[i].ext_order_id, response.tracking_codes, response.status_code);
                
                return a2w_get_next_tracking_code(data, i+1, response.status_code, callback_func);
              
              }) 
          }
          
          return true;          
          
          
    };
    
    var a2w_get_fulfilled_orders = function(callback_func){
        var data = {'action': 'a2w_get_fulfilled_orders'};

        jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    
                    if (json.state !== 'ok') {
                        console.log(json);
                    }

                    if (json.state === 'error') {
                            //do smth
                    } else {
                      
                        callback_func(json.data);
                       
                    }
                       
                }).fail(function (xhr, status, error) {    
                 });
    }

    var a2w_save_tracking_code = function(id, tracking_codes, func){
        var data = {'action': 'a2w_save_tracking_code', 'id' : id, 'tracking_codes' : tracking_codes};
        jQuery.post(ajaxurl, data).done(function (response) {
                    var json = jQuery.parseJSON(response);
                    func(json);
                       
                }).fail(function (xhr, status, error) { 
                    func(null);   
                 });
    }
});

