<?php

namespace App\DataTables\Academico;

use App\Models\Academico\Questoes\Questao;
use Illuminate\Database\Query\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class QuestoesDataTable extends DataTable
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
            ->addColumn('action', 'dashboard.academico.questoes.datatables.actions')
            ->addColumn('ativo', '{{ $ativo ? \'Ativo\' : \'Inativo\' }}')
            ->addColumn('professor', '{{ $professor[\'user\'][\'nome\'] }}');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Questao $model
     * @return Builder
     */
    public function query(Questao $model)
    {
        return $model->with('professor.user')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
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
            Column::make('titulo')->title('Título'),
            Column::make('tipo'),
            Column::make('pontos'),
            Column::make('nivel')->title('Nível'),
            Column::make('ativo')->title('Status'),
            Column::make('professor')->title('Autor'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Ações')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'questoes_' . date('YmdHis');
    }
}
