<ul class="radio">
     @if(isset($options->relationship))
        @if( !method_exists( $dataType->model_name, camel_case($row->field) ) )
            <p class="label label-warning"><i class="voyager-warning"></i> 请检查您是拥有" {{ camel_case($row->field) . '()' }} "方法在{{ $dataType->model_name }}类.</p>
        @endif
        @if( method_exists( $dataType->model_name, camel_case($row->field) ) )
            @if(isset($dataTypeContent->{$row->field}) && !is_null(old($row->field, $dataTypeContent->{$row->field})))
                <?php $selected_value = old($row->field, $dataTypeContent->{$row->field}); ?>
            @else
                <?php $selected_value = old($row->field); ?>
            @endif

                <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL; ?>

                @if(isset($options->options))
                        @foreach($options->options as $key => $option)
                        <li>
                            <input type="radio" id="option-{{ $key }}"
                                   name="{{ $row->field }}"
                                   value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $key){{ 'checked' }}@endif>
                            <label for="option-{{ $key }}">{{ $option }}</label>
                            <div class="check"></div>
                        </li>
                        @endforeach
                @endif
                {{-- Populate all options from relationship --}}
                <?php
                $relationshipListMethod = camel_case($row->field) . 'List';
                if (method_exists($dataTypeContent, $relationshipListMethod)) {
                    $relationshipOptions = $dataTypeContent->$relationshipListMethod();
                } else {
                    $relationshipClass = $dataTypeContent->{camel_case($row->field)}()->getRelated();
                    if (isset($options->relationship->where)) {
                        $relationshipOptions = $relationshipClass::where(
                            $options->relationship->where[0],
                            $options->relationship->where[1]
                        )->get();
                    } else {
                        $relationshipOptions = $relationshipClass::all();
                    }
                }

                // Try to get default value for the relationship
                // when default is a callable function (ClassName@methodName)
                if ($default != NULL) {
                    $comps = explode('@', $default);
                    if (count($comps) == 2 && method_exists($comps[0], $comps[1])) {
                        $default = call_user_func([$comps[0], $comps[1]]);
                    }
                }
                ?>

                    @foreach($relationshipOptions as $relationshipOption)
                        <li>
                            <input type="radio" id="option-{{ $relationshipOption->{$options->relationship->key} }}"
                                   name="{{ $row->field }}"
                                   value="{{ $relationshipOption->{$options->relationship->key} }}" @if($default == $relationshipOption->{$options->relationship->key} && $selected_value === NULL){{ 'checked="checked"' }}@endif @if($selected_value == $relationshipOption->{$options->relationship->key}){{ 'checked' }}@endif>
                            <label for="option-{{ $relationshipOption->{$options->relationship->key} }}">{{ $relationshipOption->{$options->relationship->label} }}</label>
                            <div class="check"></div>
                        </li>
                    @endforeach
        @else
        @endif
    @endif
</ul>