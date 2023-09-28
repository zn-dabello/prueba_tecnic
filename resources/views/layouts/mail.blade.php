<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZonaNube</title>
</head>
<body style="Margin: 0;padding: 0;min-width: 100%;background-color: #ffffff;">
    <center style="width: 100%;table-layout: fixed;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%; background-color: #fff;" >    
       
    <div  style="font-family: Arial,Helvetica,sans-serif;max-width: 600px; background-color:#fff">
        <table border="0" style="Margin: 0 auto;text-align:center;width: 100%;border-spacing: 0;max-width: 600px;" align="center"> 
             <tr>
                <td colspan="2" align="right" style="width: 600px; height: 50px; max-width: 600px; padding: 0;margin: 0;background: #4d7cde; border-top-left-radius: 10px;border-top-right-radius: 10px;"></td>
            </tr> 
            <tr>
                <td colspan="2" style="width: 600px; max-width: 600px;border-left: 1px solid #4d7cde; border-right: 1px solid #4d7cde; padding: 20px 10px 10px 10px">

                    <div>
                        <img src="{{ $_ENV['APP_URL'] }}img/zonanube/general/logo-zonanube.png" style="width:40%" style="margin: 20px;">
                    </div>
                    
                </td>
            </tr>

            <tr>
                <td colspan="2"  align="left" style="width: 600px; max-width: 600px;border-left: 1px solid #4d7cde; border-right: 1px solid #4d7cde; padding: 20px 10px 10px 10px">
                    <table width="100%">
                        <tr>
                            <td style="width: 50px;"></td>
                            <td align="left"  style="margin: 30px 20px; width: 600px; max-width: 600px; text-align:left !important">
                                 <span style="text-align: left; font-family: Arial,Helvetica,sans-serif; color: #4f4f4f; font-size: 14px; line-height: 20px; letter-spacing: 1px;">
                                    @yield('content')
                                </span>
                            </td>
                             <td style="width: 50px;"></td>
                        </tr> 
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center" style="width: 600px; max-width: 600px;border-left: 1px solid #4d7cde; border-right: 1px solid #4d7cde;">
                    <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="center" height="15px;"></td>
                        </tr> 
                    </table>
                </td>
            </tr>

            <tr>
                <td align="left" style="width: 300px; max-width: 300px; padding: 0;margin: 0;background: #4d7cde; border-bottom-left-radius: 10px; color: #FFFFFF;">
                    
                    {{-- @if( $contacto->mostrar ) --}}
                        {{-- <span style="padding-left: 20px;">Email: <span style="color: #FFFFFF !important">{{ $contacto->email_contacto }}</span></span><br> --}}
                        {{-- <span style="padding-left: 20px;">Teléfono: {{ $contacto->fono_contacto }}</span> --}}
                    {{-- @endif --}}
                    
                </td>
                <td align="right" style="width: 300px; max-width: 300px; padding: 0;margin: 0;background: #4d7cde; border-bottom-right-radius: 10px;">
                    <a href="https://zonanube.cl/" target="_blank">
                        <img src="{{ $_ENV['APP_URL'] }}img/zonanube/general/logo-zonanube-blanco.png" style="margin: 20px;">
                    </a>
                </td>
            </tr> 

        </table>
    </div>
    </center>
</body>
</html>
