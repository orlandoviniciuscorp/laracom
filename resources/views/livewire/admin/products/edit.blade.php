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
        <livewire:components.select2 :product_id="$product->id" :product_producers="$product_producers" />

    </div>
</div>