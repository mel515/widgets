@pushonce('modals:embedded_code')
    <div id="embedded_code_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Вставьте код</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content">

                        {!! Form::wysiwyg('embedded_code', '', [
                            'label' => [
                                'title' => 'Код',
                            ],
                            'field' => [
                                'class' => 'tinymce-simple',
                                'type' => 'simple',
                                'id' => 'embedded_code',
                                'cols' => '50',
                                'rows' => '10',
                            ],
                        ]) !!}

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save">Сохранить</a>
                </div>

            </div>
        </div>
    </div>
@endpushonce
