
 <?php  
 $block1=json_decode(file_get_contents('php://index'));
 $api_call_config=json_decode(file_get_contents($block1->auth->client_endpoint."app.option.get".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				 "auth"=> data->auth->access_token,
				 "login"=> data->body->result->login,
				 "psw"=> data->body->result->psw,
				 "field"=> data->body->result->field,
				 "error"=> data->body->error,
				 "error_description"=> data->body->error_description,
			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
 
 header('Content-Type: application/json');
 echo json_encode(api_call_config);

$block2=json_decode(file_get_contents('php://index'));
 $api_call_getInvoice=json_decode(file_get_contents($block2->auth->client_endpoint."crm.invoice.get".
 false,stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				 "auth"=> data->auth->access_token,
				 "id" => data->FIELDS->ID,
				 "invoice"=>data=>body=>result,
				 "error"=>data->body=>error,
				 "error_description"=> data->body->error_description,
			 )),
			 'header'=>"Content-Type: application/json\r\n".  
		 )
	 )
 )
 ));
 header('Content-Type: application/json');
 echo json_encode(api_call_getInvoice);

 $block33=json_decode(file_get_contents('php://index'));
 $api_call_requisites=json_decode(file_get_contents($block3->auth->client_endpoint."crm.requisites.link.list".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'metod'=>'POST',
			 'content'=>json_encode(array(
				 "auth"=> data->auth->access_token,
				 "filter"=> "ENITY_ID"=>data -> invoice->ID =>"ENITY_TYPE_ID"==5;
				 "select"=>data->*,
				 "order"=>"ENITY_ID"=>data->ASC,
			 )).
			 'header'=>"Content-Type: application/json\r\n".  
		 )
	 )
 )
 ));
  header('Content-Type: application/json');
 echo json_encode($api_call_requisites);

 $block4=json_decode(file_get_contents('php://index'));
 $api_call_get_client_detalies=json_decode(file_get_contents($block4->auth->client_endpoint."crm.requisite.get".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				  "auth"=> data->auth->access_token,
				  "id"=>data->req[0]->REQISITE_ID,
				  "client"=>data->body->result,
			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
 header('Content-Type: application/json');
 echo json_encode($api_call_get_client_detalies);

 $block5=json_decode(file_get_contents('php://index'));
 $api_call_get_bank_details=json_decode(file_get_contents($block5->auth->client_endpoint."crm.requisite.bankdetail.get".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				  "auth"=> data->auth->access_token,
				  "id"=>data->req[0]->MC_BANL_DETAIL_ID,
				  "bank"=>data->body->result,
			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
 header('Content-Type: application/json');
 echo json_encode($api_call_get_bank_details);
 
set($data, "Items", call_method(get(get($data, "invoice"), "PRODUCT_ROWS"), "map", new Func(function($item = null) use (&$VAT_RATE, &$parseFloat, &$items, &$PRICE, &$paseFloat) {
  $VAT_RATE = call($parseFloat, get($items, "VAT_RATE"));
  $PRICE = get($item, "VAT_INCLUDED") === "y" ? _divide(call($parseFloat, get($item, "PRICE")), _plus(1.0, _divide($VAT_RATE, 100.0))) : call($parseFloat, get($item, "PRICE"));
  return new Object(
	  "ProductName", get($item, "PRODUCT_NAME"), 
	  "UnitName", get($item, "MEASURE_NAME"), 
	  "Quantity", call($parseFloat, get($item, "QUANTITY")), 
	  "Price", _plus(call($parseFloat, get($item, "PRICE")), call($parseFloat, get($item, "DISCOUNT_PRICE"))), 
	  "PriceWithoutNds", _plus($PRICE, call($paseFloat, get($item, "DISCOUNT_PRICE"))), 
	  "Sum", to_number($PRICE) * to_number(call($parseFloat, get($item, "QUALITY"))), 
	  "NdsRate", $VAT_RATE === 18.0 ? 3.0 : ($VAT_RATE === 10.0 ? 2.0 : 0.0));
})));
if (not(get($data, "client"))) {
  set($data, "client", new Object());
}
set($data, "Contractor", new Object("Name", (is($or_ = (is($or1_ = (is($or2_ = get(get($data, "client"), "RQ_Company_Name")) ? $or2_ : get(get(get($data, "invoice"), "PROPERTIES"), "COMPANY"))) ? $or1_ : get(get(get($data, "invoice"), "PROPERTIES"), "FIO"))) ? $or_ : " "), 
"INN", (is($or_ = get(get($data, "client"), "RQ_INN")) ? $or_ : get(get(get($data, "invoice"), "INVOICE_PROPERTIES"), "INN")), 
"Kpp", (is($or_ = get(get($data, "client"), "RQ_KPP")) ? $or_ : get(get(get($data, "invoice"), "INVOICE_PROPERTIES"), "KPP"))));
set($data, "WithNds", get(get($data, "invoice"), "TAX_VALUE") !== "0.00");
if (is(get($data, "bank")) && is(get(get($data, "bank"), "RQ_ACC_NUM"))) {
  set($data, "bankAccount", new Object("AccountNumber", call_method(get(get($data, "bank"), "RQ_ACC_NUM"), "replace", new RegExp("\\s", "g"), ""), "Bank", new Object("Name", get(get($data, "bank"), "RQ_BANK_NAME"), "Bik", get(get($data, "bank"), "RQ_BIK"), "City", get($data, "RQ_BANK_ADDR"), "CorrAccount", call_method(get(get($data, "bank"), "RQ_COR_ACC_NUM"), "replace", new RegExp("\\s", "g"), ""))));
} else {
  set($data, "BankAccount", new Object());
}

set(get($data, "invoice"), "USER_DESCRIPTION", call_method(call_method((is($or_ = get(get(get($data, "invoice"), "USER"), "DESCRIPTION")) ? $or_ : ""), "replace", "null", ""), "replace", "undefined", ""));
set($data, "psw", call($encodeURIComponent, get($data, "psw")));
set($data, "login", call($encodeURIComponent, get($data, "login")));

 $block6=json_decode(file_get_contents('php://index'));
 $api_call_add=json_decode(file_get_contents($block6->auth->client_endpoint. "API/CreateBill.ashx".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				 "Number"=>data->invoice->ACOOUNT_NUMBER,
				 "Date"=>dara->invoice->DATE_BILL,
				 "WithNds"=>data=>WithNds,
				 "SumWithNds"=>false;
				 "Comment"=>data->invoice->USER_DESCRIPTION,
				 "BankAccount"=>data->BankAccount,
				 "Contractor"=>data->Contractor,
				 "Items"=>data->Items,
				 "X-login"=>data->login,
				 "X-Password"=data->psw,

			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
  header('Content-Type: application/json');
 echo json_encode($api_call_add);

set($data, "fields", new Object());
set(get($data, "fields"), "UF_CRM_ELBA", get(call_method($Object, "keys", get($data, "id")), 0.0));

$block7=json_decode(file_get_contents('php://index'));
 $api_call_update=json_decode(file_get_contents($block7->auth->client_endpoint. "crm.invoice.update".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				 "auth"=> data->auth->access_token,
				 "id"=>data->invoice->ID,
				 "fields"=>data->fields,
			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
 header('Content-Type: application/json');
 echo json_encode($api_call_update);​

set($data, "hasError", (is($and_ = get($data, "id")) ? true : $and_));
set($data, "errorText", get(call_method($Object, "keys", get($data, "id")), 0.0));

$block8=json_decode(file_get_contents('php://index'));
 $api_call_update=json_decode(file_get_contents($block8->auth->client_endpoint. "crm.invoice.update".
 false.stream_context_create(
	 array(
		 'http'=>array(
			 'method'=>'POST',
			 'content'=>json_encode(array(
				"to"=>data->invoice->RESPONSBLE_ID,
				"message"=>data->errorText,
				"type"==system,
		        "auth"=> data->auth->access_token,
			 )).
			  'header'=>"Content-Type: application/json\r\n".
		 )
	 )
 )
 ));
 header('Content-Type: application/json');
 echo json_encode($api_call_update);​

 ?>


