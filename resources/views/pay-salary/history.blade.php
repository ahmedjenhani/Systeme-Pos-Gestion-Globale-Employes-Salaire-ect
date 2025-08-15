@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Historique des paiements de salaires</h4>
                    <p class="mb-0">Un tableau de bord d'historique des paiements de salaires vous permet de rassembler et de visualiser facilement les données<br> d'historique des paiements de salaires en optimisant
                        l'expérience des paiements de salaires, garantissant<br> la rétention des paiements de salaires. </p>
                </div>
                <div>
                <a href="{{ route('advance-salary.index') }}" class="btn btn-danger add-list"><i class="fa-solid fa-trash mr-3"></i>Effacer la recherche</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('advance-salary.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Ligne:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3 align-self-center" for="search">Chercher:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="search" class="form-control" name="search" placeholder="Chercher un employé" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-primary"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>Num</th>
                            <th>Photo</th>
                            <th>@sortablelink('employee.name', 'Nom de l\'employé')</th>
                            <th>@sortablelink('date', 'Date')</th>
                            <th>@sortablelink('paid_amount', 'Montant payé')</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($paySalaries as $paySalary)
                        <tr>
                            <td>{{ (($paySalaries->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $paySalary->employee->photo ? asset('storage/employees/'.$paySalary->employee->photo) : asset('assets/images/user/1.png') }}">
                            </td>
                            <td>{{ $paySalary->employee->name }}</td>
                            <td>{{ Carbon\Carbon::parse($paySalary->date)->format('M/Y') }}</td>
                            <td>${{ $paySalary->paid_amount }}</td>
                            <td>
                                <span class="btn btn-success text-white mr-2">Entièrement Payé</span>
                            </td>
                            <td>
                                <form action="{{ route('pay-salary.destroy', $paySalary->id) }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="History" href="{{ route('pay-salary.payHistoryDetail', $paySalary->id) }}">
                                            <i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Supprimer">
                                            <i class="ri-delete-bin-line mr-0"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Données non trouvées.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $paySalaries->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
