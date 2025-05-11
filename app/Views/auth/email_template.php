<?php
/**
 * email_template.php
 * Developer: Haris
 * Date: 8/26/2022
 * Time: 19:56
 */

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

</head>
<div style="background-color:#001C2F">
    <center>
        <table style="background-color:#f2f2f2" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tbody>
            <tr>
                <td style="padding:40px 20px" align="center" valign="top">
                    <table style="width:600px" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <td align="center" valign="top">

                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:30px;padding-bottom:30px" align="center" valign="top">
                                <table style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px"
                                       border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="color:#000;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;padding-top:40px;padding-right:40px;padding-bottom:30px;padding-left:40px;text-align:center"
                                            align="center" valign="top">
                                            <img width="149.99" height="74.99"
                                                 src="<?= base_url('assets/images/mcpverify-logo.png') ?>"
                                                 class="mb-4"
                                                 align="center" valign="top"
                                                 alt="mcp-image">

                                            <h2 style="color:#95C11F;font-family: 'Nunito', sans-serif!important;">Thank
                                                you for accessing your MCP Insight
                                                Product</h2>
                                            <br>
                                            <p style="color:#000!important;;font-family: 'Nunito', sans-serif!important;"
                                               class="mb-4"><strong>Please use the verification code below to finish
                                                    logging in. This code will be valid for 5 minutes. </strong></p>
                                            <br>
                                            <br>
                                            <span style="color:#000!important;">Your Code is: <?= $code ?></span>
                                            <br>
                                            <br>
                                            <span style="color:#000!important;"> IP Address: <?= $ip ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:40px;padding-bottom:40px;padding-left:40px"
                                            align="center" valign="middle">
                                            <table style="background-color:#6dc6dd;border-collapse:separate!important;border-radius:3px"
                                                   border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                <tr>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:125%"
                                            align="center" valign="top">
                                            MCP Insight, All Rights Reserved
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:30px" align="center" valign="top">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </center>
</div>
</html>