<?php

namespace App\Transformers\Academico\Turmas;

use Carbon\Carbon;
use Google_Service_Classroom_CourseWork;
use Google_Service_Classroom_Date;
use Google_Service_Classroom_TimeOfDay;
use League\Fractal\TransformerAbstract;

/**
 * Class AtividadeTurmaClassroomTransformer
 *
 * @package App\Transformers\Academico\Turmas
 */
class AtividadeTurmaClassroomTransformer extends TransformerAbstract
{
    /**
     * @param Google_Service_Classroom_CourseWork $atividadeClassroom
     * @return string[]
     */
    public function transform(Google_Service_Classroom_CourseWork $atividadeClassroom)
    {
        $dataEntrega = null;

        if ($atividadeClassroom->getDueDate() && $atividadeClassroom->getDueTime()) {
            $dataEntrega = $this->getDataEntrega($atividadeClassroom->getDueDate(), $atividadeClassroom->getDueTime());
        }

        $dataEntrega = $dataEntrega ? Carbon::parse($dataEntrega)->toDateTimeLocalString() : null;

        return [
            'id' => $atividadeClassroom->id,
            'turma_id' => $atividadeClassroom->courseId,
            'titulo' => $atividadeClassroom->title,
            'descricao' => $atividadeClassroom->description,
            'pontos' => $atividadeClassroom->maxPoints,
            'ativo' => $atividadeClassroom->state,
            'tipo' => $atividadeClassroom->workType,
            'data_entrega' => $dataEntrega,
        ];
    }

    /**
     * Formata data e hora de entraga, gerando o atributo data_entrega.
     *
     * @param Google_Service_Classroom_Date $dueDate
     * @param Google_Service_Classroom_TimeOfDay $dueTime
     * @return String
     */
    private function getDataEntrega(Google_Service_Classroom_Date $dueDate, Google_Service_Classroom_TimeOfDay $dueTime): String {
        $carbon = new Carbon();

        $carbon->setDay($dueDate->getDay());
        $carbon->setMonth($dueDate->getMonth());
        $carbon->setYear($dueDate->getYear());
        $carbon->setHour($dueTime->getHours());
        $carbon->setMinutes($dueTime->getMinutes());
        $carbon->setSeconds($dueTime->getSeconds());

        return Carbon::parse($carbon)->toISOString();
    }
}