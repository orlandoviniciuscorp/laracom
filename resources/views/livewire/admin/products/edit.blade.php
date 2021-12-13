<div>
    <div class="col-md-3">
          <input type="hidden" wire:model="product_id" name="product_id"  >
          <input type="text" class="col-md-8" wire:model.lazy="product_name" name="product_name"
           wire:change="save"/>
    </div>
    <div class="col-md-2">
        <input type="number" required wire:model.lazy="quantity"
               wire:change="save"
               class="col-md-6"/>
    </div>
    <div class="col-md-1">
        <input type="text" pattern="[\d.]*" required wire:model.lazy="price"
               wire:change="save"  style="padding: 0px 0px 0px 0px" class="col-md-10"/>
    </div>
    <div class="col-md-1">
        <div class="form-check form-switch">
            <label class="switch">
                <input class="form-check-input"
                       type="checkbox" id="switchOne" checked="" wire:model="is_in_promotion"
                wire:change="save">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="col-md-1">

        <div class="form-check form-switch">
            <label class="switch">
                <input class="form-check-input"
                       {{--          data-toggle="toggle" data-on="Sim" data-off="Não" data-size="sm"--}}
                       type="checkbox" id="switchOne" checked="" wire:model="status"
                       wire:change="save">
                <span class="slider round"></span>
            </label>
        </div>

    </div>
    <div class="col-md-4">
{{--        <livewire:components.select2 :product_id="$product->id" :product_producers="$product_producers" />--}}
        <div wire:ignore>
            <div class="mt-5 relative" wire:ignore>
                <select name="product_producers[]" id="producer_{{$product_id}}" wire:model="product_producers" multiple="multiple"
                        class="js-example-basic-multiple" style="width: 100%" wire:key="{{$product_id}}">
                    {{--                <option value="" disabled="disabled">Select Option</option>--}}
                    @foreach(self::$producers as $producer)
                        <option value="{{ $producer->id }}">{{ $producer->name }}</option>
                    @endforeach
                </select>
                <script>
                    $(document).ready(function () {
                        $('#producer_{{$product_id}}').select2({
                            placeholder: "select languages",
                            multiple: true,
                            allowClear: false,
                        });
                        $('#producer_{{$product_id}}').on('change', function (e) {
                            var data = $('#producer_{{$product_id}}').select2("val");
                            // let closeButton = $('.select2-selection__clear')[0];
                            // if(typeof(closeButton)!='undefined'){
                            //     // if(data.length<=0)
                            //     // {
                            //     //     $('.select2-selection__clear')[0].children[0].innerHTML = '';
                            //     // } else{
                            //     //     $('.select2-selection__clear')[0].children[0].innerHTML = 'x';
                            //     // }
                            // }
                        @this.set('product_producers', data);
                        });

                        {{--$('#producer_{{$product_id}}').on('change', function (e) {--}}
                        {{--    livewire.emit('selectedProducersId', e.target.value)--}}
                        {{--});--}}
                        {{--window.livewire.on('select2',()=>{--}}
                        {{--    initSelectCompanyDrop();--}}
                        {{--});--}}
                    });

                </script>
                {{--            <div x-data="{can:@entangle('prog_lang')}" x-bind:class="can.length > 0 ? 'hidden': 'absolute top-2 right-1'" >--}}
                {{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
                {{--                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />--}}
                {{--                </svg>--}}
                {{--            </div>--}}
            </div>
        </div>

    </div>
</div>