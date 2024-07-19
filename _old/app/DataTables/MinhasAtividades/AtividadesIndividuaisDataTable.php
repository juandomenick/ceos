<?php

namespace App\DataTables\MinhasAtividades;

use App\Models\Academico\AtividadeDesignavel;
use App\Models\Usuarios\Aluno;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * Class AtividadesIndividuaisDataTable
 *
 * @package App\DataTables\MinhasAtividades
 */
class AtividadesIndividuaisDataTable extends DataTable
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
            ->eloquent($query)
            ->addColumn('disciplina', function (AtividadeDesignavel $atividade) {
                return $atividade->atividade->disciplina->nome;
            })
            ->addColumn('status', function (AtividadeDesignavel $atividade) {
                return $atividade->respondida ? 'Respondida' : 'Pendente';
            })
            ->addColumn('action', 'dashboard.minhas-atividades.individuais.datatables.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param AtividadeDesignavel $model
     * @return Builder
     */
    public function query(AtividadeDesignavel $model)
    {
        return $model->newQuery()->where('atividade_designavel_type', Aluno::class);
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
            Column::make('disciplina'),
            Column::make('descricao')->title('Descrição'),
            Column::make('pontos'),
            Column::make('tempo'),
            Column::make('status'),
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
        return 'atividades-individuais_' . date('YmdHis');
    }
}
