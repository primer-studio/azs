<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h5 class="kt-portlet__head-title">
                @lang('general.log')
                @lang('general.activity')
            </h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <!--begin::Accordion-->
        <div class="accordion" id="logs-accordion">
            @forelse(\Facades\App\Libraries\ProfileLogHelper::getTranslated($profile->id) as $log)
                <div class="card">
                    <div class="card-header" id="log-labelledby-target-{{ $log->id }}">
                        <div class="card-title collapsed d-flex justify-content-lg-between" data-toggle="collapse" data-target="#log-accordion-target-{{ $log->id }}" aria-expanded="false" aria-controls="log-accordion-target-{{ $log->id }}">
                            <div>
                                {!! $log->translated_message !!}
                                @if(!empty($log->short_message))
                                     ({{ $log->short_message }})
                                @endif
                            </div>
                            <div class="dir-ltr">{{ jdateComplete($log->created_at) }}</div>
                        </div>
                    </div>
                    <div id="log-accordion-target-{{ $log->id }}" class="collapse" aria-labelledby="log-labelledby-target-{{ $log->id }}" data-parent="#logs-accordion">
                        <div class="card-body">
                            @if($log->data_type == 'array')
                                <pre class="dir-ltr text-left">
                                    {{ print_r(json_decode($log->data, true)) }}
                                </pre>
                            @elseif($log->data_type == null)
                                <div class="text-center"> --- </div>
                            @else
                                {{ $log->data_type }}
                            @endif
                        </div>
                    </div>
                </div>
                <!--end::Accordion-->
            @empty
                <div class="text-center">
                    @lang('general.not_found')
                </div>
            @endforelse
        </div>
    </div>
</div>
