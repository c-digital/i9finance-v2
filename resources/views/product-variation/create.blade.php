{{ Form::open(array('url' => 'product-variation','enctype' => "multipart/form-data")) }}
    <div class="modal-body">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="name">{{ __("Variant name") }}</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
        </div>

        <hr>

        <div class="paramters-container">
            <div class="row mb-3">
                <div class="col">
                    <b>{{ __('Parameters:') }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-5">
                    <label for="name">{{ __('Name') }}</label>
                </div>

                <div class="col-5">
                    <label for="name">{{ __('Options (Separated by comma)') }}</label>
                </div>
            </div>

            <div class="row">
                <div class="col-5">
                    <div class="form-group">                        
                        <input type="text" class="form-control" name="parameters[0][name]">
                    </div>
                </div>

                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="parameters[0][options]">
                        <input type="text" class="form-control" name="parameters[0][prices]">
                    </div>
                </div>

                <div class="col-2">
                    <button class="btn btn-info btn-block add-new-parameter" type="button">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
{{ Form::close() }}

<script>
    $(document).ready(function () {
        i = 1;

        $('.add-new-parameter').click(function () {
            html = `
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <input type="text" class="form-control" name="parameters[${i}][name]">
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="form-group">
                            <input type="text" class="form-control" name="parameters[${i}][options]">
                            <input type="text" class="form-control" name="parameters[${i}][prices]">
                        </div>
                    </div>

                    <div class="col-2">
                        <button class="btn btn-danger btn-block" onclick="removeParameter(this)" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            i++;

            $('.paramters-container').append(html);
        });
    });

    function removeParameter(element) {
        $(element).parent().parent().remove();
    }
</script>
