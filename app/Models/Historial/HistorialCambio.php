<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

use App\Models\Historial\HistorialListado;
use App\Models\Historial\HistorialRegistro;
use App\Models\Historial\HistorialTipoRegistro;

class HistorialCambio extends Model
{
    
    protected $table = 'historial_cambios';
	protected $fillable = [
        'historial_id',  'historial_label_id', 'anterior', 'nuevo'
    ];

    public function hitoriales()
    {
      return $this->belongsTo('App\Historial');
    }
    public function historialLabel()
    {
      return $this->belongsTo('App\HistorialLabel');
    }

    public function historialDetalle($historial = false, $historial_registro = false, $listado = false)
    {
        if ( $historial ){
            $datos_formulario = [];
            $cambios  =  HistorialCambio::select(['historial_cambios.id', 'historial_cambios.anterior', 'historial_cambios.nuevo', 'historial_cambios.created_at', 'historial_labels.id as label_id', 'historial_labels.label'])
                                    ->join('historial_labels', 'historial_labels.id', 'historial_cambios.historial_label_id')
                                    ->where('historial_cambios.historial_id', $historial)
                                    ->get();


            $cambios = $cambios->map(function ($detalle) {

                $anterior_nohtml = htmlspecialchars(strip_tags($detalle->anterior));
                $nuevo_nohtml = htmlspecialchars(strip_tags($detalle->nuevo));
                
                // Anterior truncado
                if (mb_strlen($detalle->anterior) > 45) {

                    if ( $detalle->anterior == $anterior_nohtml ) {
                        $detalle->anterior = '<div class="icon-descripcion zn-clickable" contenido="'.($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($anterior_nohtml, false, false)).'"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"></i>  '.($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($anterior_nohtml, 40, false)).'</div>';
                    } else {
                        $detalle->anterior = '<div class="icon-descripcion-editable zn-clickable" contenido="detalleHistorialAnterior' . $detalle->id . '"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"><span id="detalleHistorialAnterior' . $detalle->id . '" type="hidden" style="display:none;">'.$detalle->anterior.'</span> </i>  ' . quitarSaltoLinea($anterior_nohtml, 40, false) . '</div>';
                    }

                }
                // Anterior sin truncar
                else{
                  $detalle->anterior = ( !empty($detalle->anterior) ? ($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($detalle->anterior, false, false)) : '-');
                }

                // NUEVO truncado
                if (mb_strlen($detalle->nuevo) > 45) {

                    if ( $detalle->nuevo == $nuevo_nohtml ) {
                        $detalle->nuevo = (!empty($detalle->nuevo) ? '<div class="icon-descripcion zn-clickable" contenido="'.($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($detalle->nuevo, false, false)).'"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"></i>  '.($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($nuevo_nohtml,40, false)).'</div>' : '-');
                    } else {
                        $detalle->nuevo = '<div class="icon-descripcion-editable zn-clickable" contenido="detalleHistorialNuevo' . $detalle->id . '"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"><span id="detalleHistorialNuevo' . $detalle->id . '" type="hidden" style="display:none;">'.$detalle->nuevo.'</span> </i>  ' . quitarSaltoLinea($nuevo_nohtml, 40, false) . '</div>';
                    }
                }
                // nuevo sin truncar
                else{
                  $detalle->nuevo = ( !empty($detalle->nuevo) ? ($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($nuevo_nohtml, false, false)) : '-');
                }


                return $detalle;
            });

            $cambios =  $cambios->toArray();

            $datos_formulario['cambios'] = $cambios;

            $datos_formulario['listado'] = [];

            if ( $listado ){

                // Se obtiene los IDs de listado
                $idListado   =   HistorialRegistro::select(['listados'])
                                    ->where('historial_registros.id', $historial_registro)
                                    ->where('historial_registros.cliente_id',session('plataforma.user.cliente.id'))
                                    ->get()
                                    ->first()
                                    ->toArray();



                $idListado   =   mb_split(',', $idListado['listados']);

                if (!empty($idListado)) {

                    foreach ($idListado as $key => $listado) {

                        $datos_historial_listado = HistorialListado::historial($historial_registro, $listado, $historial);
                        $datos_historial_listado = $datos_historial_listado->map(function ($detalle) {

                            // Registro truncado
                            if (mb_strlen($detalle->registro) > 30) {

                                $detalle->registro = '<div class="icon-descripcion zn-clickable" contenido="'.($detalle->label_id == 4 ? $detalle->registro : quitarSaltoLinea($detalle->registro, false, false)).'">'.($detalle->label_id == 4 ? $detalle->registro : quitarSaltoLinea($detalle->registro, 30, false)).'  <i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"></i></div>';
                            }
                            // Registro sin truncar
                            else{
                              $detalle->registro = ( !empty($detalle->registro) ? ($detalle->label_id == 4 ? $detalle->registro : quitarSaltoLinea($detalle->registro, false, false)) : '-');
                            }
                            return $detalle;
                        });
                        // $datos_formulario['listado'][$key]  =  HistorialTipoRegistro::nombreID($listado);
                        $datos_formulario['listado'][$key]['historial'] = $datos_historial_listado->toArray();

                    }
                }
                
                
            }
            
            return $datos_formulario;
        }

        return false;
    }

    public function historialDetalleListado($historial = false, $historial_registro = false, $listado = false)
    {
        if ( $historial ){
            $datos_formulario = [];
            $cambios  =  HistorialListadoCambio::select(['historial_listado_cambios.id', 'historial_listado_cambios.anterior', 'historial_listado_cambios.nuevo', 'historial_listado_cambios.created_at', 'historial_labels.id as label_id', 'historial_labels.label'])
                                    ->join('historial_labels', 'historial_labels.id', 'historial_listado_cambios.historial_label_id')
                                    ->where('historial_listado_cambios.historial_listado_id', $historial)
                                    ->get();


            $cambios = $cambios->map(function ($detalle) {

                $detalle->anterior = htmlspecialchars(strip_tags($detalle->anterior));
                $detalle->nuevo = htmlspecialchars(strip_tags($detalle->nuevo));
                
                // Anterior truncado
                if (mb_strlen($detalle->anterior) > 45) {

                    $detalle->anterior = '<div class="icon-descripcion zn-clickable" contenido="'.($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($detalle->anterior, false, false)).'"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"></i>  '.($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($detalle->anterior, 40, false)).'</div>';
                }
                // Anterior sin truncar
                else{
                  $detalle->anterior = ( !empty($detalle->anterior) ? ($detalle->label_id == 4 ? $detalle->anterior : quitarSaltoLinea($detalle->anterior, false, false)) : '-');
                }

                // NUEVO truncado
                if (mb_strlen($detalle->nuevo) > 45) {

                    $detalle->nuevo = (!empty($detalle->nuevo) ? '<div class="icon-descripcion zn-clickable" contenido="'.($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($detalle->nuevo, false, false)).'"><i class="zn-sprite observaciones" data-toggle="tooltip" data-placement="top" title="Descripción"></i>  '.($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($detalle->nuevo,40, false)).'</div>' : '-');
                }
                // nuevo sin truncar
                else{
                  $detalle->nuevo = ( !empty($detalle->nuevo) ? ($detalle->label_id == 4 ? $detalle->nuevo : quitarSaltoLinea($detalle->nuevo, false, false)) : '-');
                }


                return $detalle;
            });

            $cambios =  $cambios->toArray();

            $datos_formulario['cambios'] = $cambios;

            $datos_formulario['listado'] = [];

            if ( $listado ){

                // Se obtiene los IDs de listado
                $idListado   =   HistorialRegistroListado::select(['listados'])
                                    ->where('historial_registros.id', $historial_registro)
                                    ->where('historial_registros.cliente_id',session('plataforma.user.cliente.id'))
                                    ->get()
                                    ->first()
                                    ->toArray();



                $idListado   =   mb_split(',', $idListado['listados']);

                if (!empty($idListado)) {

                    foreach ($idListado as $key => $listado) {

                        $datos_historial_listado = HistorialListado::historial($historial_registro, $listado, $historial);
                        $datos_formulario['listado'][$key]  =  HistorialTipoRegistro::nombreID($listado);
                        $datos_formulario['listado'][$key]['historial'] = $datos_historial_listado;

                    }
                }
                
                
            }
            
            return $datos_formulario;
        }

        return false;
    }
}
