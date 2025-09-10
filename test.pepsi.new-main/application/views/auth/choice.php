<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="col-lg-12">
    <table style="border-collapse:collapse;width: 100%;" border="0">
                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><h1><b> <?php echo $company['CompanyName'] ?></b></h1></td>
                                </tr> 
                                <tr style="text-align:center;font-size:25px;">
                                    <td colspan="4"><b><?php echo $company['CompanyName2'] ?></b></td>
                                </tr>
                                <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4"><?php echo $company['AddressLine01'] ?>, <?php echo $company['AddressLine02'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4"><?php echo $company['LanLineNo'] ?>, <?php echo $company['MobileNo'] ?></td>
                                </tr>
                                <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4"> Well Come <?php echo $_SESSION['fname']?></td>
                                </tr>
                                 <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
<!--                                 <tr style="text-align:center;font-size:20px;">
                                     <td colspan="2">Counter Number</td><td colspan="2">  <select class="form-control"><option value="1">1</option><option value="2">2</option><<option value="3">3</option>/select></td>
                                </tr>
                                 <tr style="text-align:center;font-size:20px;">
                                    <td colspan="4">&nbsp;</td>
                                </tr>-->
                                <tr style="text-align:center;font-size:20px;">
                                    <td colspan="2"><a href="<?php echo site_url('admin'); ?>"  class="btn btn-success btn-lg" > <i class="fa fa-sign-in"></i> Admin</a></td>
                                    <td colspan="2"><a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger  btn-lg" ><i class="fa fa-sign-out"></i> Logout</a></td>
                                </tr>
                            </table>
</div>

