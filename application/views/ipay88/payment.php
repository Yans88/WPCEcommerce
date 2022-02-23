<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>OneCheckout - Payment Page</title>


<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>	
</head>

<body>


<div style="clear:both">Loading...<br/><img src="<?php echo base_url('assets/Preloader_1.gif');?>" width="30px"></div>
<form method="POST" name="ePayment" action="<?php echo $url_payment;?>" id="form_paymentku">
<input name="MerchantCode" type="hidden" id="MerchantCode" value="<?php echo $merchantCode;?>"  maxlength="20" size="100" />
<input name="PaymentId" type="hidden" id="PaymentId" value="<?php echo $paymentId;?>" maxlength="1" size="100" />
<input name="RefNo" type="hidden" id="RefNo" value="<?php echo $refno;?>" maxlength="20" size="100" />
<input name="Amount" type="hidden" id="Amount" value="<?php echo $amount;?>" size="100" />
<input name="Currency" type="hidden" id="Currency" value="IDR" maxlength="5" size="100" />
<input name="ProdDesc" type="hidden" id="ProdDesc" value="<?php echo $prodDesc;?>" maxlength="100" size="100" />
<input name="UserName" type="hidden" id="UserName" value="<?php echo $userName;?>" maxlength="100" size="100" />
<input name="UserEmail" type="hidden" id="UserEmail" value="<?php echo $userEmail;?>" maxlength="100" size="100" />
<input name="UserContact" type="hidden" id="UserContact" value="<?php echo $userContact;?>" maxlength="20" size="100" />
<input name="Remark" type="hidden" id="Remark" value="<?php echo $remark;?>" maxlength="100" size="100" />
<input name="Lang" type="hidden" id="Lang" value="UTF-8" maxlength="20" size="100" />
<input name="Signature" type="hidden" id="Signature" value="<?php echo $signature;?>" maxlength="100" size="100" />
<input name="ResponseURL" type="hidden" id="ResponseURL" maxlength="200" value="<?php echo site_url('ipay_notif/ipay88_redirect');?>" size="100" />
<input name="BackendURL" type="hidden" id="BackendURL" maxlength="200" value="<?php echo site_url('ipay_notif');?>" size="100" />



</form>  

<script type="text/javascript">
$(document).ready(function (e) {
    
    $("#form_paymentku").submit();
	return false;
});

</script>

</body>
</html>

