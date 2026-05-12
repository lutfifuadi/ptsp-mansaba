@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin Form - Select2 & Tags')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/tagify/tagify.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/typeahead-js/typeahead.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/typeahead-js/typeahead.js',
    'resources/assets/vendor/libs/bloodhound/bloodhound.js'
  ])
@endsection

@section('page-script')
  @vite([
    'resources/assets/js/forms-selects.js',
    'resources/assets/js/forms-tagify.js',
    'resources/assets/js/forms-typeahead.js'
  ])
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold mb-1">Form Elements</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Select2 & Tags</li>
      </ol>
    </nav>
  </div>
</div>

<div class="row">
  <!-- Select2 -->
  <div class="col-12 mb-4">
    <div class="card">
      <h5 class="card-header">Select2</h5>
      <div class="card-body">
        <div class="row g-6">
          <!-- Basic -->
          <div class="col-md-6 mb-3">
            <label for="select2Basic" class="form-label">Basic Select2</label>
            <select id="select2Basic" class="select2 form-select" data-allow-clear="true">
              <option value="AK">Alaska</option>
              <option value="HI">Hawaii</option>
              <option value="CA">California</option>
              <option value="NV">Nevada</option>
              <option value="OR">Oregon</option>
              <option value="WA">Washington</option>
              <option value="AZ">Arizona</option>
              <option value="CO">Colorado</option>
            </select>
          </div>
          <!-- Multiple -->
          <div class="col-md-6 mb-3">
            <label for="select2Multiple" class="form-label">Multiple Select2</label>
            <select id="select2Multiple" class="select2 form-select" multiple>
              <optgroup label="Alaskan/Hawaiian Time Zone">
                <option value="AK">Alaska</option>
                <option value="HI">Hawaii</option>
              </optgroup>
              <optgroup label="Pacific Time Zone">
                <option value="CA">California</option>
                <option value="NV">Nevada</option>
                <option value="OR">Oregon</option>
                <option value="WA">Washington</option>
              </optgroup>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tagify -->
  <div class="col-12 mb-4">
    <div class="card">
      <h5 class="card-header">Tagify (Tags)</h5>
      <div class="card-body">
        <div class="row g-6">
          <!-- Basic -->
          <div class="col-md-6 mb-3">
            <label for="TagifyBasic" class="form-label">Basic Tags</label>
            <input id="TagifyBasic" class="form-control" name="TagifyBasic" value="Tag1, Tag2, Tag3" />
          </div>
          <!-- Custom Suggestions: Inline -->
          <div class="col-md-6 mb-3">
            <label for="TagifyCustomInlineSuggestion" class="form-label">Custom Inline Suggestions</label>
            <input id="TagifyCustomInlineSuggestion" name="TagifyCustomInlineSuggestion" class="form-control"
              placeholder="select technologies" value="css, html, javascript" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
