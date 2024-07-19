<?php

namespace App\DataTables\Academico;

use App\Models\Academico\Equipe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Html\Builder as DataTablesBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

/**
 * Class EquipesDataTable
 *
 * @package App\DataTables\Academico
 */
class EquipesDataTable extends DataTable
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
            ->editColumn('data_formacao', function (Equipe $equipe) {
                return Carbon::make($equipe->data_formacao)->format('d/m/Y');
            })
            ->addColumn('status', function (Equipe $equipe) {
                return $equipe->ativo ? 'Ativa' : 'Inativa';
            })
            ->addColumn('action', 'dashboard.academico.equipes.datatables.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param Equipe $model
     * @return Builder
     */
    public function query(Equipe $model)
    {
        return $model->newQuery();
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
            Column::make('nome'),
            Column::make('data_formacao')->title('Data de Formação'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return date('YmdHis');
    }
}
