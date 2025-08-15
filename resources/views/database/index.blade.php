<!-- resources/views/database/index.blade.php -->
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
            @if (session()->has('error'))
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-text">{{ session('error') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Liste de sauvegarde de base de données</h4>
                </div>
                <div>
                    <a href="{{ route('backup.create') }}" class="btn btn-primary add-list">Sauvegarder maintenant</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>Num</th>
                            <th>Nom du fichier</th>
                            <th>Taille du fichier</th>
                            <th>Chemin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @foreach ($files as $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->getFilename() }}</td>
                            <td>{{ $file->getSize() }} bytes</td>
                            <td>{{ $file->getPath() }}</td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Download"
                                       href="{{ route('backup.download', $file->getFilename()) }}">
                                        <i class="fa-solid fa-download mr-0"></i>
                                    </a>
                                    <form action="{{ route('backup.delete', $file->getFilename()) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="Supprimer">
                                            <i class="fa-solid fa-trash mr-0"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
@endsection