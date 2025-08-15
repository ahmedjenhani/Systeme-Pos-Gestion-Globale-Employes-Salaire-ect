@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-block">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <div class="iq-header-title">
                        <h4 class="card-title mb-0">Facture</h4>
                    </div>

                    <div class="invoice-btn d-flex">
                        <form action="{{ route('pos.printInvoice') }}" method="post">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <button type="submit" class="btn btn-primary-dark mr-2"><i class="las la-print"></i> Imprimer</button>
                        </form>

                        <button type="button" class="btn btn-primary-dark mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">Créer</button>

                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-white">
                                        <h3 class="modal-title text-center mx-auto">Facture de {{ $customer->name }}<br/>Montant Total ${{ Cart::total() }}</h3>
                                    </div>
                                    <form action="{{ route('pos.storeOrder') }}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="payment_status">Mode de Paiement</label>
                                                    <select class="form-control @error('payment_status') is-invalid @enderror" name="payment_status">
                                                        <option selected="" disabled="">-- Sélectionner le Mode de Paiement --</option>
                                                        <option value="HandCash">Espèces</option>
                                                        <option value="Cheque">Chèque</option>
                                                        <option value="Due">Dû</option>
                                                    </select>
                                                    @error('payment_status')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="pay">Payer Maintenant</label>
                                                    <input type="text" class="form-control @error('pay') is-invalid @enderror" id="pay" name="pay" value="{{ old('pay') }}">
                                                    @error('pay')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="{{ asset('assets/images/logo.png') }}" class="logo-invoice img-fluid mb-3">
                            <h5 class="mb-3">Bonjour, {{ $customer->name }}</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date de commande</th>
                                            <th scope="col">Statut de la commande</th>
                                            <th scope="col">Adresse de facturation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Carbon\Carbon::now()->format('d M<, Y') }}</td>
                                            <td><span class="badge badge-danger">non rémunéré</span></td>
                                            <td>
                                                <p class="mb-0">{{ $customer->address }}<br>
                                                    Nom du magasin: {{ $customer->shopname ? $customer->shopname : '-' }}<br>
                                                    Téléphone: {{ $customer->phone }}<br>
                                                    Email: {{ $customer->email }}<br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">resumet commande</h5>
                            <div class="table-responsive-lg">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">#</th>
                                            <th scope="col">Article</th>
                                            <th class="text-center" scope="col">Quantité</th>
                                            <th class="text-center" scope="col">Prix</th>
                                            <th class="text-center" scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($content as $item)
                                        <tr>
                                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <h6 class="mb-0">{{ $item->name }}</h6>
                                            </td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-center">{{ $item->price }}</td>
                                            <td class="text-center"><b>{{ $item->subtotal }}</b></td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <b class="text-danger">Notes:</b>
                            <p class="mb-0">Le numéro de facture doit être unique et séquentiel.

La mention "TVA non applicable, art. 293 B du CGI" peut être ajoutée si vous êtes en franchise de TVA.

Pour les entreprises assujetties à la TVA, le numéro de TVA intracommunautaire doit figurer.

Ce modèle est conforme aux exigences légales tunisiennes.</p>
                        </div>
                    </div>

                    <div class="row mt-4 mb-3">
                        <div class="offset-lg-8 col-lg-4">
                            <div class="or-detail rounded">
                                <div class="p-3">
                                    <h5 class="mb-3">Détails de la commande</h5>
                                    <div class="mb-2">
                                        <h6>Sous-total</h6>
                                        <p>${{ Cart::subtotal() }}</p>
                                    </div>
                                    <div>
                                        <h6>TVA (5%)</h6>
                                        <p>${{ Cart::tax() }}</p>
                                    </div>
                                </div>
                                <div class="ttl-amt py-2 px-3 d-flex justify-content-between align-items-center">
                                    <h6>Total</h6>
                                    <h3 class="text-primary font-weight-700">${{ Cart::total() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
