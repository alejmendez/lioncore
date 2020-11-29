<?php

namespace App\Http\Controllers;

// Control Base
use App\Http\Controllers\Controller as BaseController;

// Traits
use App\Traits\ApiResponse;

// Modelos
use DB;

class GraficaController extends BaseController
{
    use ApiResponse;

    public function data()
    {
        $grupo = request('grupo');
        $indicador = request('indicador');

        if ($grupo == 'semester') {
            $groupBy = 'semester';
            $legend = ['I-2016', 'II-2016', 'I-2017', 'II-2017', 'I-2018', 'II-2018', 'I-2019', 'II-2019', 'I-2020', 'II-2020'];
        } else {
            $groupBy = 'specialty';
            $legend = ['Sistemas', 'Informática', 'Mantenimiento', 'Ambiental'];
        }

        $sql = DB::table('registros')
            ->select($groupBy . ' as name', DB::raw('count(*) as value'))
            ->leftJoin('alumnos', 'alumnos.id', '=', 'registros.alumno_id')
            ->groupBy($groupBy)
            ->orderBy($groupBy);

        switch ($indicador) {
            case 'aprobados_por_semestre':
                $sql->where('registros.tutor', 0);
                break;
            case 'sin_tutor_académico_asignado':
                $sql->where('registros.tutor', 0);
                break;
            case 'inasistentes_a_asesorías_académicas':
                $sql->where('registros.consultancies', 0);
                break;
            case 'sin_completar_requisitos_académicos':
                $sql->where('registros.tutor', 0);
                $sql->where('registros.consultancies', 0);
                $sql->where('registros.documentation', 0);
                $sql->where('registros.assignedDate', 0);
                $sql->where('registros.presentation', 0);
                $sql->where('registros.finalTome', 0);
                break;
            case 'inasistentes_a_presentación_de_teg':
                $sql->where('registros.presentation', 0);
                break;
            case 'sin_entrega_de_tomo_final_de_teg':
                $sql->where('registros.finalTome', 0);
                break;
        }

        $data = $sql->get();



        return $this->showResponse([
            'legend' => $legend,
            'data'   => $data
        ]);
    }
}
