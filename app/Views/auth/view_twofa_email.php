<?php
	/**
	 * view_twofa_email.php
	 * Developer: Haris
	 * Date: 8/26/2022
	 * Time: 19:57
	 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet"/>
   
</head>

<body>
<style>
    * {
        font-family: "Nunito" !important;

    }

    body {
        font-family: "Nunito" !important;
        /* background-color: #001C2F; */
    }

    .card {
        box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: 1rem;
    }

    .img-thumbnail {
        padding: .25rem;
        background-color: #ecf2f5;
        border: 1px solid #dee2e6;
        border-radius: .25rem;
        max-width: 100%;
        height: auto;
    }

    .avatar-lg {
        height: 150px;
        width: 150px;
    }

    .bg-indigo-400 {
        background-color: #23609A !important;
    }

    .border-grey {
        border: solid 2px gray !important;

    }

    input:focus {
        border: solid 2px gray !important;
        box-shadow: 0 0 0 1px #808080 !important;
    }

    
    .text-blue{
        color: #1D9BCE !important;
    }
    
    .bg-blue{
        background-color: #1D9BCE !important;
    }
</style>

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-5 col-md-7 mx-auto my-auto">
            <div class="card">
                <div class="card-body px-lg-5 py-lg-5 text-center">
                    <img
                    class="mb-4"
                    width="200" height="100"
                    src="<?= base_url('assets/images/mcpverify-logo.png') ?>"
                         alt="mcp-image">
                    <h2 class="text-success" style="font-size:30px;">Thank you for accessing your<br>MCP Insight Product</h2>
                    <p class="mb-4" style="font-size:16px !important">
                    <strong>A 6-digit verification code has been sent to your email.<br>This code will be
                            valid for 5 minutes.</strong></p>
                    <form method="post" action="<?= base_url('auth/email-verification') ?>">
                        <?= csrf_field() ?>
                        <div class="row mb-4 check">
                            <div class="col-lg-12 col-md-12 col-12 ps-0 ps-md-2">
                                <input id="one" autofocus name='twofa' type="text"
                                       class="form-control text-lg text-center inputs" placeholder="Please enter code"
                                       aria-label="2fa" maxlength="6" autocomplete="off">
                            </div>
							<?php if (!empty($message)): ?>
                                <p class="<?= (!$error) ? 'text-black' : 'text-danger' ?> mt-4" style="font-size:13px;"><?= $message ?></p>
							<?php endif; ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg my-4 text-white">Verify</button>

                        </div>
                        <div class="text-center">
                            <a href="<?= base_url('auth/authentication') ?>" class="text-success" style="text-decoration:none">Resend Code</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</html>