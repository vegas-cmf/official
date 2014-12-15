<div class="row widget recruiter-new">
    <div class="col-xs-12">
        <div class="widget widget-default-spacer">
            <div class="spacer spacer30"></div>
        </div>
        <div class="widget widget-page-header">
            <h3>{{ i18n._('Update profile') }}</h3>
        </div>
        <div class="widget widget-default-spacer">
            <div class="spacer spacer22"></div>
        </div>
        <div class="widget widget-default-page">
            <div class="row widget">
                <div class="col-xs-12">
                    <div class="widget widget-content">                            
                        <div class="form-edit">
                            <form action="{{ url.get(['for': 'admin/user', 'action': 'update', 'params': record._id]) }}" method="POST" role="form">
                                {{ partial('./backend/user/_form', ['form': form]) }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>