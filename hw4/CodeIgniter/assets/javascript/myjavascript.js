
$(document).ready(function(event){
                  $("button.signup").click(function(){
                                           $("div.signup").toggle();
                                           $("div.login").toggle();
                                           });
                  $("button.login").click(function(){
                                          $("div.login").toggle();
                                          $("div.signup").toggle();
                                          });
                  $("button.order-details").click(function(){
                                                  $(this).closest("tr").nextUntil("tr.main").toggle();
                                                  });
                  $("input.button-cart-special").click( function(event){
                                                  event.preventDefault();
                                                  var count= $(this).parents('form:first').find('#add-cart-special').val();
                                                  var id= $(this).parents('form:first').find('#productid-cart-special').val();
                                                  var price= $(this).parents('form:first').find('#productprice-cart-special').val();
                                                  $.ajax({
                                                         url :  'http://cs-server.usc.edu:11111/CodeIgniter/index.php/item/addtocart',
                                                         type : 'POST', //the way you want to send data to your URL
                                                         data : {
                                                                productid : id,
                                                                count : count,
                                                                price : price
                                                         },
                                                         success : function(data){ //probably this request will return anything, it'll be put in var "data"
                                                            $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                                         }
                                                         });
                                                  
                                                  });
                  $("input.button-cart").click( function(event){
                                                       event.preventDefault();
                                                       var count= $(this).parents('form:first').find('#add-cart').val();
                                                       var id= $(this).parents('form:first').find('#productid-cart').val();
                                                       var price= $(this).parents('form:first').find('#productprice-cart').val();
                                                       $.ajax({
                                                              url :  'http://cs-server.usc.edu:11111/CodeIgniter/index.php/item/addtocart',
                                                              type : 'POST', //the way you want to send data to your URL
                                                              data : {
                                                              productid : id,
                                                              count : count,
                                                              price : price
                                                              },
                                                              success : function(){ //probably this request will return anything, it'll be put in var "data"
                                                              $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                                              }
                                                              });
                                                       
                                                       });
                  $("input.delete-product").click( function(event){
                                               event.preventDefault();
                                               var count= $(this).parents('form:first').find('#add-cart').val();
                                               var id= $(this).parents('form:first').find('#productid-cart').val();
                                               var price= $(this).parents('form:first').find('#productprice-cart').val();
                                               var mytable = $(this).parent().parents('tr:first');
                                               $.ajax({
                                                      url :  'http://cs-server.usc.edu:11111/CodeIgniter/index.php/item/deleteproduct',
                                                      type : 'POST', //the way you want to send data to your URL
                                                      data : {
                                                      productid : id,
                                                      count : count,
                                                      price : price
                                                      },
                                                      success : function(data){ //probably this request will return anything, it'll be put in var "data"
                                                      mytable.fadeOut('slow');
                                                      $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                                      }
                                                      });
                                               
                                               });
                  $("input.delete-all").click( function(event){
                                              event.preventDefault();
                                              $.ajax({
                                                     url :  'http://cs-server.usc.edu:11111/CodeIgniter/index.php/item/deleteallproduct',
                                                     type : 'POST', //the way you want to send data to your URL
                                                     success : function(data){ //probably this request will return anything, it'll be put in var "data"
                                                     $("table:first").fadeOut('slow');
                                                     $("#delete-form").fadeOut('slow');
                                                     $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                                     }
                                                     });
                                              
                  });
                  $("input.update-cart-number").change( function(event){
                                                  event.preventDefault();
                                                  var count= $(this).parents('form:first').find('#add-cart').val();
                                                  var id= $(this).parents('form:first').find('#productid-cart').val();
                                                  var price= $(this).parents('form:first').find('#productprice-cart').val();
                                                  $.ajax({
                                                         url :  'http://cs-server.usc.edu:11111/CodeIgniter/index.php/item/updateproduct',
                                                         type : 'POST', //the way you want to send data to your URL
                                                         data : {
                                                         productid : id,
                                                         count : count,
                                                         price : price
                                                         },
                                                         success : function(data){ //probably this request will return anything, it'll be put in var "data"
                                                         $("#myElem").fadeIn('slow').delay(1000).fadeOut('slow');
                                     
                                                         }
                                                         });
                                                  
                                                  });
                  
                  });

$(document).ready(function(){
                var id = $("#my-hidden-id").html();
                if(document.getElementsByName("button-cart-special-name")){
                    var btns = document.getElementsByName("button-cart-special-name");
                    if(id == "NA"){
                        document.getElementById("please-login").innerHTML = "Please login to shop!";
                    };
                    for(var i = 0; i < btns.length; i++){
                        if(id == "NA" ){
                            if(!btns[i].hasAttribute("disabled")){
                                btns[i].addAttribute("disabled");
                            };
                        }else{
                            if(btns[i].hasAttribute("disabled")){
                                btns[i].removeAttribute("disabled");
                            };
                        };
                    }
                  };
                if(document.getElementsByName("button-cart-name")){
                    var btns = document.getElementsByName("button-cart-name");
                    if(id == "NA"){
                        document.getElementById("please-login").innerHTML = "Please login to shop!";
                    };
                    for(var i = 0; i < btns.length; i++){
                        if(id == "NA"){
                            if(!btns[i].hasAttribute("disabled")){
                                btns[i].addAttribute("disabled");
                            };
                        }else{
                            if(btns[i].hasAttribute("disabled")){
                                btns[i].removeAttribute("disabled");
                            };
                        };
                    }
                  };
});
