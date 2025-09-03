<table style="border-collapse:collapse;width:700px;margin:5px;font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;" border="0">
    <tr>
        <td rowspan="2" style="width: 300px;padding-left: 20px;"><?php $logo =  $company['Logo']; ?>
            <img style="width: 200px;" src="<?php echo base_url($avatar_dir . '/'.$logo); ?>"  alt="logo">
        </td>
        <td style="width: 100px;"></td>
        <td style="font-size:40px;width: 200px;text-align: right;"  id="title"><?php echo $title; ?></td>
    </tr>
    <tr>
        <td></td>
        <td style="font-size:20px;text-align: right;" id="titleno"># <?php echo $titleno; ?></td>
    </tr>
    <tr>
        <td style="font-size:20px;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?></td>
        <td></td>
        <td style="font-size:15px;text-align: right;"><?php echo $balancetxt; ?></td>
    </tr>
    <tr>
        <td><?php echo $company['AddressLine03'] ?></td>
        <td></td>
        <td style="font-size:20px;text-align: right;" rowspan="2"><?php echo $balance; ?></td>
    </tr>
    <tr>
        <td><?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo $company['MobileNo'] ?></td>
        <td></td>
        <!-- <td></td> -->
    </tr>
</table>