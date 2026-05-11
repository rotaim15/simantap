@extends('layouts.app')

@section('title', 'Edit Surat Masuk — ' . $suratMasuk->no_agenda)
@section('page-title', 'Surat Masuk')

@section('breadcrumb')
<a href="{{ route('surat-masuk.index') }}" class="hover:text-slate-600">Surat Masuk</a>
/ <