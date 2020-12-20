<?php
$output .= '<!doctype html>
                <html>
                <head>
                <meta charset="utf-8">
                <title></title>

                <style>
                * {
                    box-sizing: border-box;
                }
                body {
                    margin: 0;
                }
                p {
                    margin: 0
                }
                a {
                    text-decoration: none;
                    color: inherit;
                }/*a的設定*/
                .clearfix:before, .clearfix:after {
                    visibility: hidden;
                    display: block;
                    font-size: 0;
                    content: " ";
                    clear: both;
                    height: 0;
                }
                .clearfix {
                    zoom: 1;
                }/*清理浮動*/
                .content {
                    width: 960px;
                    margin: 0 auto;
                    line-height: 30px;
                    font-size: 16px;
                    font-family: arial, \'微軟正黑體\', \'Microsoft JhengHei\';
                    color: #333333;
                }
                /*td {
                    border: solid 1px #333;
                    border-bottom: none;
                    padding-left: 1%
                }*/
                .red {
                    color: #38964c
                }
                .left {
                    float: left
                }
                .right {
                    float: right
                }
                .right img {
                    padding-top: 38px;
                }
                .title {
                    width: 100%;
                    height: 38px;
                    color: #ffffff;
                    font-size: 16px;
                    padding-left: 5px;
                    line-height: 38px;
                    font-weight: bold;
                    margin-bottom: 8px;
                    border-bottom-color: #d1d6d6;
                    border-bottom-width: 6px;
                    border-bottom-style: solid;
                    background: #ffd582;
                    display: block
                }
                .margin-top {
                    margin-top: 2%
                }
                .lett-1 {
                    padding: 0 36px;
                }
                .lett-2 {
                    padding-left: 13px
                }
                footer {
                    line-height: 38px;
                    color: #ffffff;
                    font-size: 16px;
                    background: #ffd582;
                    text-align: center;
                    font-size: 14px;
                    letter-spacing: 1px;
                    margin-top: 3%
                }
                footer img {
                    vertical-align: middle;
                    margin-left: 5px
                }
                .table-name {
                    border: 1px solid #333;
                    padding-left: 1%
                }
                .product-1, .product-2, .product-3, .product-4 {
                    float: left;
                    padding-left: 1%
                }
                .product-1 {
                    width: 460px;
                    border-left: 1px solid #333;
                    border-bottom: 1px solid #333;
                }
                .product-2 {
                    width: 154px;
                    border-left: 1px solid #333;
                    border-bottom: 1px solid #333;
                }
                .product-3 {
                    width: 154px;
                    border-left: 1px solid #333;
                    border-bottom: 1px solid #333;
                    border-right: 1px solid #333
                }
                .product-4 {
                    width: 192px;
                    border-right: 1px solid #333;
                    border-bottom: 1px solid #333;
                }
                .settlement {
                    border-right: 1px solid #333;
                    border-left: 1px solid #333;
                    text-align: right
                }
                .settlement p {
                    padding-right: 1%
                }
                </style>
                </head>
                <body>
                <div class="content">
                  <div class="header clearfix">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>
                            <a href="' . URL . 'index.php" target="_blank" border="0">
                                <img src="' . URL . 'email/images/logo3.png" border="0" style="display: block;">
                            </a>
                        </td>
                      </tr>
                    </table>
                  </div>
                <div class="order">
                ' . $message . '
                </div>
                <table class="mainFooter" style="width: 100%; background: #e59e20;" bgcolor="#663366">
                    <thead>
                        <tr>
                            <td>
                                <img src="' . URL . 'email/images/copyright.jpg" border="0" class="img" style="display: inline-block; float: left;" align="left">
                                <a href="https://www.facebook.com/singwucake/" target="_blank">
                                    <img src="' . URL . 'email/images/ft_fb.jpg" border="0" class="img" style="display: inline-block; float: left;" align="left"></a>
                                <a href="https://www.asiaway.com.tw" target="_blank">
                                    <img src=""' . URL . 'email/images/design.jpg" border="0" class="img" style="display: inline-block; float: left;" align="left"></a>
                            </td>
                        </tr>
                    </thead>
                </table>
                </div>
                </body>
                </html>';
