<div id="pricing-plans" class="pricing-plans-area area-padding">
  <div class="container">
    <div class="section-headline text-center">
      <h2>Choose Your Plan</h2>
    </div>
    <div class="row">
        <div class="plan col-md-4 col-sm-4 col-xs-12">
          <div class="pri_table_list">
            <h3>$52</h3>
            <h4>BASIC</h4>

            <p>Up to 8000 words</p>
            <p>$0.065 per word</p>
            <p>Proofreading</p>
            <p>Unlimited Revisions</p>
            <p>2 Days Delivery</p>

            <form method="post" action="cart">
              @csrf()
              <input type="hidden" name="product_id" value="1" />
              <button type="submit">Order Now</button>
            </form>
          </div>
        </div>
        <div class="plan col-md-4 col-sm-4 col-xs-12">
          <div class="pri_table_list active">
            <h3>$120</h3>
            <h4>STANDARD</h4>

            <p>Up to 2000 words</p>
            <p>$0.06 per word</p>
            <p>Proofreading</p>
            <p>Unlimited Revisions</p>
            <p>3 Days Delivery</p>

            <form method="post" action="cart">
              @csrf()
              <input type="hidden" name="product_id" value="2" />
              <button type="submit">Order Now</button>
            </form>
          </div>
        </div>
        <div class="plan col-md-4 col-sm-4 col-xs-12">
          <div class="pri_table_list text-center">
            <h3>$275</h3>
            <h4>PREMIUM</h4>

            <p>Up to 5000 words</p>
            <p>$0.055 per word</p>
            <p>Proofreading</p>
            <p>Unlimited Revisions</p>
            <p>3 Days Delivery</p>

            <form method="get" action="cart">
              @csrf()
              <input type="hidden" name="product_id" value="3" />
              <button type="submit">Order Now</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>
