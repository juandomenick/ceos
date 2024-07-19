<?php

namespace App\DataTables\Academico\Turmas;

use App\Repositories\Academico\Turmas\AtividadeTurmaRepositoryEloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Exceptions\RepositoryException;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AtividadeTurmaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->editColumn('data_entrega', function ($atividadeTurma) {
                $atividadeTurma = (object) $atividadeTurma;
                $dataEntrega = $atividadeTurma->data_entrega;

                return $dataEntrega ? Carbon::parse($dataEntrega)->format('d/m/Y H:i') : 'Indefinida';
            })
            ->addColumn('action', function ($atividadeTurma) {
                $atividadeTurma = (object) $atividadeTurma;

                return view('dashboard.academico.turmas.atividades.datatables.actions')
                    ->with(['id' => $atividadeTurma->id, 'turma' => $this->turma]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param AtividadeTurmaRepositoryEloquent $atividadeTurmaRepository
     * @return Builder
     * @throws RepositoryException
     */
    public function query(AtividadeTurmaRepositoryEloquent $atividadeTurmaRepository)
    {
        return $atividadeTurmaRepository->getByTurma($this->turma->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return DataTablesBuilder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('titulo'),
            Column::make('pontos'),
            Column::make('data_entrega'),
            Column::computed('action')
                ->title('Ações')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'turma_atividades_' . date('YmdHis');
    }
}
