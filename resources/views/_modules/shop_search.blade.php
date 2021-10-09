            <div class="bloc_with_header bloc_vote">
				<div class="bloc_header">
					<h2>{!! Lang::get('all.shop.search_title') !!}</h2>
				</div>
				<div class="bloc_body center container_shop_categories">
                    <table>
                        <tr><td>
    					{!! Form::open(['class' => 'navbar-form navbar-right', 'url' => Route('shop.search'), 'method' => 'get']) !!}
    					<div class="form-group">
    						{!! Form::text('search_value', null, ['placeholder' => "Item", 'class' => 'input']) !!}
                        </div>
                        <div class="form-group" style="margin-top: 5px;">
    						<p><input type="submit" class="btn" value="{!! Lang::get('all.shop.search_btn') !!}" /></p>
    					</div>
    					{!! Form::close() !!}
                        </td></tr>
                    </table>
				</div>
            </div>
