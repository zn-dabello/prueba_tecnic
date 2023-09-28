@extends('layouts.mail')
@section('content')
<!-- INICIO CONTENDOR GENERAL -->
    <!-- #!FieldStr01!#, participa por 5 millones este lunes -->
    <div  style="font-family: Arial,Helvetica,sans-serif;max-width: 600px; background-color:#fff">
            <table border="0" style="Margin: 0 auto;text-align:center;width: 100%;border-spacing: 0;" align="center">

                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td align="left"  style="margin: 30px 20px; width: 600px; max-width: 600px; text-align:left !important">
                                     <span style="text-align: left; font-family: Arial,Helvetica,sans-serif; color: #4f4f4f; font-size: 14px; line-height: 20px; letter-spacing: 1px;">
                                        Estimado(a) Sr.(a) <b></b>
                                    </span>
                                </td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="center" height="15px;"></td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td align="left"  style="margin: 30px 20px; width: 600px; max-width: 600px; text-align:justify !important">
                                     <span style="text-align: justify; font-family: Arial,Helvetica,sans-serif; color: #4f4f4f; font-size: 14px; line-height: 14px; letter-spacing: 1px;">
                                        Usted ha solicitado una nueva contraseña de ingreso al sistema Portal ZonaNube. Para continuar con su solicitud haga clic en el siguiente enlace para poder cambiar su contraseña de acceso.
                                    </span>
                                </td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="center" height="15px;"></td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" class="emailButton" style="border-radius:4px; background-color:#4d7cde;">
                            <tr>
                                <td align="center" valign="middle" style="padding-top:10px; padding-right:30px; padding-bottom:10px; padding-left:30px;">
                                    <a href="{{url(config('app.url').route('password.reset', $this->token, false))}}" target="_blank" style="color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:14px; text-decoration:none;">Clic Aquí para cambiar su contraseña</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td align="center" height="15px;"></td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table align="center" valign="middle" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" height="10px;" style="width:600px;"><hr style="width: 95%;opacity: .7;" /></td>
                            </tr> 
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td style="width: 600px; max-width: 600px;">
                                         <span style="text-align: justify !important;  margin-top: 30px; font-family: Arial,Helvetica,sans-serif; color: #4f4f4f; font-size: 14px; line-height: 20px; letter-spacing: 1px;">
                                            Si usted no ha solicitado una nueva contraseña puede borrar este mensaje.
                                        </span>

                                </td>
                            </tr>       
                        </table>
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
    </div>
    <!-- FIN CONTENDOR GENERAL -->
@endsection