<!-- <table style="border-collapse:collapse;width:700px;margin:5px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;" border="0">
    <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5" style="font-size:20px;font-family: Arial, Helvetica, sans-serif;text-align: left;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b>


        </td>
        <td rowspan="3">
            <?php $logo =  $company['Logo']; ?>
            <img style="width: 100px;" src="<?php echo base_url($avatar_dir . '/'.$logo); ?>"  alt="logo">
        </td>
    </tr> 
    <tr style="text-align:left;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?></td>
    </tr>
    <tr style="text-align:left;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo $company['MobileNo'] ?></td>
    </tr>
    <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
        <td colspan="6">&nbsp;</td>
    </tr>
</table> -->
<table style="border-collapse:collapse;width:590px;margin:5px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;" border="0">
    <tr style="text-align:left;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
        <td rowspan="4">
            <?php $logo =  $company['Logo']; ?>
            <!--<img style="width: 100px;" src="<?php// echo base_url($avatar_dir . '/'.$logo); ?>"  alt="logo">-->
        </td>
        <td colspan="5" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;text-align: right;"><b> <?php echo $company['CompanyName'] ?> </b>


        </td>
        
    </tr> 
    <tr style="text-align:right;color:#9a9494 !important;font-size:13px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
    </tr>
    <tr style="text-align:right;color:#9a9494 !important;font-size:13px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['AddressLine03'] ?></td>
    </tr>
    <tr style="text-align:right;color:#9a9494 !important;font-size:13px;font-family: Arial, Helvetica, sans-serif;">
        <td colspan="5"><?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo $company['MobileNo'] ?></td>
    </tr>
    <!-- <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
        <td colspan="6">&nbsp;</td>
    </tr> -->
</table>