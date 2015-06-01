    <section class="content-header">
        <h1>{!! Theme::place('title') !!}</h1>
        {!! Theme::breadcrumb()->render() !!}
        <div class="row">
            <div class="col-md-12">
                @set($actions, Theme::getActions())
                @if(isset($actions['header']) && count($actions['header']))
                <div class="actions-menu pull-right">
                    @foreach($actions['header'] as $btn)
                    <a class="{{ $btn['btn-class'] }}" href="{{ route($btn['btn-link']) }}">
                        <span class="btn-label"><i class="{{ $btn['btn-icon'] }}"></i></span> <span>{{ $btn['btn-text'] }}</span>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    <div class="col-md-12">
        {!! Theme::partial('theme.msgs') !!}
    </div>
