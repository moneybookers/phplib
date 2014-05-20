<?php
/**
 * Simple class with static methods that hold predefined json request parameters 
 * for different type of requests. It is consumed by all other request class 
 * @package SkrillPsp
 */
class SkrillPsp_Json {
	
	/**
	 * PRE-AUTHORISATION request
	 * @return string $json
	 */
	static public function getPreauthorisationJson()
	{
		 return $json = <<<PREAUTH
  		  {
    		"jsonrpc": "2.0",
    		"method": "preauthorization",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount": "",
            				"currency": "",
            				"descriptor": ""
        				},
        				"account": {
            				"cardholder": "",
            				"number": "",
            				"expiry": "",
            				"cvv": ""
        			   	},
        				"customer": {
            				"name": {
                				"title": "",
                				"firstname": "",
                				"lastname": "",
                				"company": ""
            				},
            				"address": {
                				"street": "",
                				"zip": "",
                				"city": "",
                				"state": "",
                				"country": ""
            				},
            				"contact": {
                				"phone": "",
                				"mobile": "",
                				"email": "",
                			    "ip": ""
            				}
        			  }
    			},
    		"id": ""
  		}		 
PREAUTH;
	}
	
	/**
	 * REGISTER REQUEST
	 * @return string $json
	 */
	static public function getRegisterJson()
	{
		return $json = <<<REGISTER
			{
    			"jsonrpc": "2.0",
    			"method": "register",
    				"params": {
        				"account": {
            				"number": "",
            				"expiry": "",
            				"cvv": ""
        			   	}
    				},
    			"id": ""
			}		  
REGISTER;
	}
	
	/**
	 * REFUND REQUEST
	 * @return string $json
	 */
	static public function getRefundJson()
	{
		return $json = <<<REFUND
			{
    			"jsonrpc": "2.0",
    			"method": "refund",
    				"params": {
        				"identification": {
            					"transactionid": "",
            					"customerid": "",
            					"referenceid": ""
        				},
        				"payment": {
            					"amount": "",
            					"currency": "",
            					"descriptor": ""
        				},
                                        "account": {
            					"username": "",
            					"password": ""
        				}
    				},
    			"id": ""
			}		
REFUND;
	}
	
	/**
	 * CAPTURE REQUEST
	 * @return string $json
	 */
	static public function getCaptureJson()
	{
		 return $json = <<<CAPTURE
			{
    			"jsonrpc": "2.0",
    			"method": "capture",
    				"params": {
        				"identification": {
            					"transactionid": "",
            					"customerid": "",
            					"referenceid": ""
        				},
        				"payment": {
            					"amount": "",
            					"currency": "",
            					"descriptor": ""
        				}
    				},
    			"id": ""
			}		  
CAPTURE;
	}
	
	/**
	 * DEBIT REQUEST
	 * @return string
	 */
	static public function getDebitJson()
	{
		return $json = <<<DEBIT
  		  {
    		"jsonrpc": "2.0",
    		"method": "debit",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount": "",
            				"currency": "",
            				"descriptor": ""
        				},
        				"account": {
            				"cardholder": "",
            				"number": "",
            				"expiry": "",
            				"token" : "",
            				"cvv": ""
        			   	},
        				"customer": {
            				"name": {
                				"title": "",
                				"firstname": "",
                				"lastname": "",
                				"company": ""
            				},
            				"address": {
                				"street": "",
                				"zip": "",
                				"city": "",
                				"state": "",
                				"country": ""
            				},
            				"contact": {
                				"phone": "",
                				"mobile": "",
                				"email": "",
                			    "ip": ""
            				}
        			  }
    			},
    		"id": ""
  		} 		
DEBIT;
	}
	
	/**
	 * CREDIT REQUEST
	 * @return string $json
	 */
	static public function getCreditJson()
	{
		  return $json = <<<REQUEST
  		  {
    		"jsonrpc": "2.0",
    		"method": "credit",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount": "",
            				"currency": "",
            				"descriptor": ""
        				},
        				"account": {
            				"cardholder": "",
            				"number": "",
            				"expiry": "",
            				"token" : "",
            				"cvv": ""
        			   	},
        				"customer": {
            				"name": {
                				"title": "",
                				"firstname": "",
                				"lastname": "",
                				"company": ""
            				},
            				"address": {
                				"street": "",
                				"zip": "",
                				"city": "",
                				"state": "",
                				"country": ""
            				},
            				"contact": {
                				"phone": "",
                				"mobile": "",
                				"email": "",
                			    "ip": ""
            				}
        			  }
    			},
    		"id": ""
  		}   
REQUEST;
	}
	
	static public function getCancelJson()
	{
		 return $json = <<<CANCEL
			{
    			"jsonrpc": "2.0",
    			"method": "cancel",
    				"params": {
        				"identification": {
            					"transactionid": "",
            					"referenceid": ""
        				},
        				"payment": {
            					"amount": "",
            					"currency": "",
            					"descriptor": ""
        				}
    				},
    			"id": ""
			}		
CANCEL;
	}
	
	static public function getReversalJson()
	{
		 return $json = <<<REVERSAL
			{
    			"jsonrpc": "2.0",
    			"method": "reversal",
    				"params": {
        				"identification": {
            					"transactionid": "",
		 		                "customerid":"",
            					"referenceid": ""
        				}
    				},
    			"id": ""
			}		
REVERSAL;
	}
	
	static public function getAlternativeWithAccountJson()
	{
		 return $json = <<<ALTERNATIVE
  		  {
    		"jsonrpc": "2.0",
    		"method": "",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount":     "",
            				"currency":   "",
		 		            "country" :   "",
            				"descriptor": ""
        				},
        				"account": {
							
        			   	},
		 				"frontend" : {
							"language" : "",
						    "responseurl": "",
                            "successurl": "",
                            "errorurl" : ""
                         },
        				"customer": {
            				"name": {
                				"salutation": "",
                				"firstname": "ghghgh",
                				"lastname": ""
            				},
            				"address": {
                				"street": "",
                				"zip": "",
                				"city": "",
                				"state": "",
                				"country": ""
            				},
            				"contact": {
                				"phone": "",
                				"mobile": "",
                				"email": "",
                			    "ip": ""
            				}
        			  },
		 			  "merchant" : {
		 		            
					  }
    			},
    		"id": ""
  		} 		 
ALTERNATIVE;
	}
	
	static public function getBoletoJson()
	{
		  return $json = <<<BOLETO
  		  {
    		"jsonrpc": "2.0",
    		"method": "preauthorization",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount":     "",
            				"currency":   "",
		 		            "country" :   "",
            				"descriptor": ""
        				},
        				"account": {
							"fiscal_id" : ""
        			   	},
		 				"frontend" : {
							"language" : "",
						    "responseurl": "",
                            "successurl": "",
                            "errorurl" : "",
		  		            "cancelurl" : ""
                         },
        				"customer": {
            				"contact": {
                				"email": "",
                			    "ip": ""
            				}
        			  },
		 			  "merchant" : {
		 		            
					  }
    			},
    		"id": ""
  		} 			       
BOLETO;
	}
	
	static public function getAlternativeWithoutAccountJson()
	{
		 return $json = <<<ALTERNATIVE
  		  {
    		"jsonrpc": "2.0",
    		"method": "",
    			"params": {
        				"identification": {
            				"transactionid": "",
                            "customerid": ""
                        },
        				"payment": {
            				"amount":     "",
            				"currency":   "",
		 		            "country" :   "",
            				"descriptor": ""
        				},
		 				"frontend" : {
							"language" : "",
						    "responseurl": "",
                            "successurl": "",
                            "errorurl" : ""
                         },
        				"customer": {
            				"contact": {
                				"email": "",
                			    "ip": ""
            				}
        			  },
		 			  "merchant" : {
		 		           "key" : "value"
					  }
    			},
    		"id": ""
  		}		 
ALTERNATIVE;
	}
	
	static public function getSkrillWalletPreauthorization()
	{
		 return $json = <<<SkrillWalletPreauthorization
		      {
  					"jsonrpc" : "2.0",
  					"method" : "preauthorization",
  					"params" : 
     				 {
						"identification" : {
								"transactionid" : "",
								"customerid" : ""
						},
                                                "account" : {
								"username" : "",
								"password" : ""
						},
						"payment" : {
            					"amount": "",   
            					"currency" : "",
            					"descriptor" : "",
            					"payment_methods": []
        				},
       					"frontend" : {
           						"amount_details" : [
              						["", ""],
              						["", ""],
              						["", ""]
          						],
          						"responseurl": "",
          						"successurl": {
             						"url" : "",
             						"text": "",
             						"target": ""
          						},
         						"errorurl" : {
            						"url" : "",
            						"target": ""
         						},
         						"new_window_redirect": "",
         						"language": "",
         						"confirmation_note": "",
         						"logo_url": "",
         						"rid": "",
         						"ext_ref_id": "",
         						"detail_descriptions" : [
            							["", ""],
            							["", ""]
          						]
        			  },
					  "customer" : {
							"name" : {
								"salutation" : "",
								"title" : "",
								"firstname" : "",
								"lastname" : "",
								"company" : ""
							},
							"address" : {
								"street" : "",
								"zip" : "",
								"city" : "",
								"state" : "",
								"country" : ""
							},
							"contact" : {
                        		"phone" : "",
								"mobile" : "",
								"email" : "",
								"ip" : ""
							}
					},
					"merchant" : {
		 		        
	                 }                    
					
    		},
  			"id" : 1
		 }
		 
SkrillWalletPreauthorization;
	}
	
	static public function getSkrillWalletSendMoneyJson()
	{
		  return $json = <<<JSON
		  {
				"jsonrpc": "2.0", 
		  		"method": "credit",
				"params": {
					"identification": {
						"transactionid": "",
						"customerid": ""
					},
                                        "account": {
						"username": "",
						"password": ""
					},
					"payment": { 
		  		         "amount": "", 
		  		         "currency": "", 
		  		         "subject": "", 
		  		         "note": ""
					},
                                        "frontend" : {
                                          "responseurl": ""
                                        },
					"customer": {
						  "name": { 
		  		                  "firstname": "", 
		  		                  "lastname":  ""
						  },
						  "contact": { 
		  		               "email": "", 
		  		               "ip": ""
						  }
					}
				},
				"id": ""
			}		  
JSON;
	}
	
	static public function getSkrillWalletRecurringBillingJson()
	{
		   return $json = <<<JSON
		   {
    			"jsonrpc": "2.0",
    			"method": "preauthorization",
    			"params": {
        			"identification": {
           				 "transactionid": "",
            			 "customerid": ""
        			},
        			"payment": {
            			"amount": "",
            			"currency": "",
            			"descriptor": "",
            			"payment_methods": []
        			},
        			"recurrence": {
            			"rec_amount": "",
            			"rec_start_date": "",
            			"rec_end_date": "",
            			"rec_period": "",
            			"rec_cycle": "",
            			"rec_grace_period": "",
            			"rec_status_url": "",
            			"res_status_url2": ""
        			},
        			"frontend": {
            			"amount_details": [
                			["", ""]
                       
                        ],
            			"responseurl": "",
            			"successurl": {
                			"url": "",
                			"text": "",
                			"target": ""
            			},
            			"errorurl": {
                			"url": "",
                			"target": ""
            			},
            			"new_window_redirect": "",
            			"language": "",
            			"hide_login": "",
            			"confirmation_note": "",
            			"logo_url": "",
            			"rid": "",
            			"ext_ref_id": "",
            			"detail_descriptions": [
                			["", ""]
            			]
        			},
        			"customer": {
            			"name": {
                			"salutation": "",
                			"title": "",
               				"firstname": "",
                			"lastname": "",
                			"company": ""
            			},
            			"address": {
                			"street": "",
                			"zip": "",
                			"city": "",
                			"state": "",
                			"country": " "
            			},
            			"contact": {
                			"phone": "",
                			"mobile": "",
                			"email": "",
                			"ip": ""
            			}
        		  },
        		"merchant": {
        		}
    		},
    		"id": ""
}
JSON;
	}
	
	
	static public function getPaySafeCardCreateDispositionJson()
	{
		  return $json = <<<JSON
	{
  		"jsonrpc" : "2.0",
  		"method" : "createDisposition",
  		"params" : 
      		{
				"identification" : {
					"transactionid" : "",
					"customerid" : ""
				},
				"payment" :{
					"amount" : "",
					"currency" : ""
				},
	"account" : {
				"locale" : "",
                "kyclevel" : "",
                "language" : "",
                "minage" : "",
                "shopid" : "",
                "shoplable" : "",
                "country" : ""
	},
    "frontend" : {
                "responseurl": "",
                "successurl": "",
                "errorurl" : ""
    },
	"customer" : {
		"name" : {
			"salutation" : "",
			"title" : "",
			"given" : "",
			"family" : "",
			"company" : ""
		},
		"address" : {
			"street" : "",
			"zip" : "",
			"city" : "",
			"state" : "",
			"country" : ""
		},
		"contact" : {
             "phone" : "",
			 "mobile" : "",
			 "email" : "",
			 "ip" : ""
       }
   },
	"merchant" : {
		"key0" : "Value0"
	 }
   },
    "id" : 1
}		  
JSON;
	}
	
	static public function getPaySafeCardPAJson()
	{
		  return $json = <<<JSON
	      {
    "jsonrpc": "2.0",
    "method": "preauthorization",
    "params": {
        "identification": {
            "transactionid": "",
            "customerid": ""
        },
        "payment": {
            "amount": "",
            "currency": ""
        },
        "account": {
            "kyclevel": "",
            "country_restriction": ""
        },
        "frontend": {
            "responseurl": "",
            "successurl": "",
            "errorurl": ""
        },
        "customer": {
            "name": {
                "salutation": "",
                "title": "",
                "given": "",
                "family": "",
                "company": ""
            },
            "address": {
                "street": "",
                "zip": "",
                "city": "",
                "state": "",
                "country": ""
            },
            "contact": {
                "phone": "",
                "mobile": "",
                "email": "",
                "ip": ""
            }
        },
        "merchant": {
            "key0": "Value0"
        }
    },
    "id": ""
} 
JSON;
	}
	
	static public function getSkirllDirectJson()
	{
		 return $json = <<<JSON
{
    "jsonrpc": "2.0",
    "method": "preauthorization",
    "params": {
        "identification": {
            "transactionid": "",
            "customerid": ""
        },
        "payment": {
            "amount": "",
            "currency": "",
            "descriptor": "",
            "recipient": ""
        },
        "account": {
            "holder": "",
            "accountnumber": "",
            "routingnumber": "",
            "country": ""
        },
        "frontend": {
            "successurl": "",
            "errorurl": "",
            "responseurl": "",
            "language": ""
        },
        "customer": {
            "name": {
                "salutation": "",
                "title": "",
                "firstname": "",
                "lastname": "",
                "company": ""
            },
            "address": {
                "street": "",
                "zip": "",
                "city": "",
                "state": "",
                "country": ""
            },
            "contact": {
                "phone": "",
                "mobile": "",
                "email": "",
                "ip": ""
            }
        },
        "merchant": {

        }
    },
    "id": 1
}			 
JSON;
	}
	
	static public function getQIWICreateInvoiceJson()
	{
	    
	}
	
	static public function getQIWIJson()
	{
		
	}
	
	static public function test()
	{
		  return $json = <<<TEST
{
    "jsonrpc": "2.0",
    "method": "preauthorization",
    "params": {
        "identification": {
            "transactionid": "MerchantAssignedID",
            "customerid": "customerid 12345"
        },
        "payment": {
            "amount": "184",
            "currency": "eur",
            "descriptor": "descriptor line",
            "payment_methods": [
                "SFT",
                "LSR"
            ]
        },
        "recurrence": {
            "rec_amount": "184",
            "rec_start_date": "20/12/2013",
            "rec_end_date": "23/12/2014",
            "rec_period": 14,
            "rec_cycle": "hour",
            "rec_grace_period": 7,
            "rec_status_url": "https://psp.dev.skrillws.net/okurl",
            "res_status_url2": "https://psp.dev.skrillws.net/okurl"
        },
        "frontend": {
            "amount_details": [
                [
                    "184",
                    "amount1 description"
                ],
                [
                    "184",
                    "amount2 description"
                ],
                [
                    "184",
                    "amount3 description"
                ]
            ],
            "responseurl": "https://psp.dev.skrillws.net/okurl",
            "successurl": {
                "url": "http://pancho.skrillbox.com/bernhard/response.php",
                "text": "Return to sample merchant",
                "target": "4"
            },
            "errorurl": {
                "url": "http://pancho.skrillbox.com/bernhard/response.php",
                "target": "4"
            },
            "new_window_redirect": "1",
            "language": "EN",
            "hide_login": "1",
            "confirmation_note": "Thanks for shopping with us",
            "logo_url": "https://nelly.com/img/nellylogotyp_com_smal.png",
            "rid": "123456",
            "ext_ref_id": "AffiliateName",
            "detail_descriptions": [
                [
                    "detail description",
                    "detail text"
                ],
                [
                    "detail description",
                    "detail text"
                ],
                [
                    "detail description",
                    "detail text"
                ],
                [
                    "detail description",
                    "detail text"
                ],
                [
                    "detail description",
                    "detail text"
                ]
            ]
        },
        "customer": {
            "name": {
                "salutation": "Mr",
                "title": "Mr",
                "firstname": "John",
                "lastname": "Doe",
                "company": "Skrill"
            },
            "address": {
                "street": "Karl-Liebknecht-Strasse 5",
                "zip": "10117",
                "city": "Berlin",
                "state": "BE",
                "country": "UK"
            },
            "contact": {
                "phone": "+49302341423",
                "mobile": "+49 172 931 44 01",
                "email": "mbcust4321@abv.bg",
                "ip": "127.0.0.1"
            }
        },
        "merchant": {
            "key0": "Value0",
            "key1": "Value1",
            "key2": "Value2",
            "key3": "Value3"
        }
    },
    "id": 1
}
TEST;
	}
	
	static public function getOneTapRegisterJson()
	{
		  return $json = <<<ONETABREGISTER
			{
  				"jsonrpc" : "2.0",
  				"method" : "onetap",
  				"params" : 
      			{
					"identification" : {
							"transactionid" : "",
							"customerid" : ""
					},
					"payment" : {
            				"amount": "",   
            				"currency" : "",
           					"descriptor" : "",
            				"payment_methods": ["", ""],
            				"ondemand_max_amount" : "",
            				"ondemand_note" : ""
        			},
       				"frontend" : {
           				"amount_details" : [
              				["", ""],
              				["", ""],
              				["", ""]
          				],
          				"responseurl": "",
          				"successurl": {
             				"url" : "",
             				"text": "",
            				"target": ""
          				},
         			"errorurl" : {
            			"url" : "",
            			"target": ""
         			},
         			"new_window_redirect": "",
         			"language": "",
         			"hide_login": "",
         			"confirmation_note": "",
         			"logo_url": "",
         			"rid": "",
         			"ext_ref_id": "",
         			"detail_descriptions" : [
            			    ["", ""],
            				["", ""]
          			]
       			 },
                                 "account": {
                                        "username":"",
                                        "password":""
                                  },
				 "customer" : {
							"name" : {
								"salutation" : "",
							    "title" : "",
								"firstname" : "",
							    "lastname" : "",
								"company" : ""
							},
							"address" : {
								"street" : "",
							    "zip" : "",
								"city" : "",
								"state" : "",
								"country" : ""
							},
							"contact" : {
                        		"phone" : "",
								"mobile" : "",
								"email" : "",
								"ip" : ""
							}
				},
				"merchant" : {
				}
    		},
  			"id" : 1
		}		  
ONETABREGISTER;
	}
	
	static public function getOneTapJson()
	{
		 return $json = <<<ONETABREFERENCE
			{
  				"jsonrpc" : "2.0",
  				"method" : "onetap",
  				"params" : {
					"identification" : {
						   "transactionid" : "",
						   "customerid" : ""
	                },
					"payment" : {
            			 "amount": "",   
            			 "currency" : "",
            			 "descriptor" : ""
                   },
                   "account" : {
                          "token" : ""
                   }
                },
                "id" : ""
             }
		 		
ONETABREFERENCE;
	}
	
	static public function getEmailCheckJson()
	{
		 return $json = <<<EMAILCHECK
		    {
  				"jsonrpc" : "2.0",
  				"method" : "email",
  				"params" : 
      			{
					"identification" : {
						"transactionid" : "",
						"customerid" : ""
					},
					"account" : {
            			"email": ""
        			}
    			},
  				"id" : ""
			}
		 
EMAILCHECK;
	}
	
	
}

?>
