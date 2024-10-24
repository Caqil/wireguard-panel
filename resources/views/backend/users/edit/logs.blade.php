@extends('backend.layouts.grid')
@section('title', $user->name . ' | Login logs')
@section('back', route('admin.users.index'))
@section('content')
    <div class="row">
        <div class="col-lg-3">
            @include('backend.includes.userlist')
        </div>
        <div class="col-lg-9">
            <div class="card custom-card">
                <div class="card-body">
                    @if (!demoMode())
                        @forelse ($logs as $log)
                            <div class="logs-box justify-items-center">
                                <div class="content ms-1 d-flex justify-content-between">
                                    <span>
                                        <h5><a href="{{ route('admin.users.logsbyip', $log->ip) }}">{{ $log->ip }}</a>
                                        </h5>
                                        <p class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $log->location }}
                                        </p>
                                    </span>
                                    <span>
                                        <a href="#" data-user="{{ $user->id }}" data-log="{{ $log->id }}"
                                            class="billiongroup-getlog-btn btn btn-blue btn-sm"><i
                                                class="ti ti-device-desktop"></i></a>
                                    </span>
                                </div>
                            </div>
                        @empty
                            @include('backend.includes.empty')
                        @endforelse
                    @else
                        <div>{{ admin_lang('Hidden in demo') }}</div>
                    @endif
                </div>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
    @include('backend.includes.logsmodal')
@endsection
