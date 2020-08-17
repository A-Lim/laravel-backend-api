
<html>
  <head>
    <style>
      body { font-family: 'Open Sans', sans-serif; }

      span, li, td, h1, p {
        color: #444;
      }

      a { color: #444; }
      a:hover { color: #e3d0a8; }

      header { 
        height: 70px; 
        background-color: #000; 
        display: table; 
        width: 100%;
      }

      header > a {
        padding: 15px; 
        display: table; 
        margin: auto;
        text-decoration: none;
      }

      header > a > img {
        height: 40px; 
        display:inline-block; 
        margin-right: 5px;
      }

      header > a > .logo-text {
        display: table-cell; 
        vertical-align: middle;
        color: #fff;
      }

      .svg-green-tick { text-align: center; }
      .svg-green-tick > svg {
        height: 50px;
      }

      .container {
        margin: 40px auto;
        background-color: #f9f9f9;
        padding: 20px;
        max-width: 550px;
        min-width: 400px;
      }

      .text-center { text-align: center; }
      .text-right { text-align: right; }
      .col-price { vertical-align: text-top; }

      .order-details {
        margin: auto; 
        width: 90%; 
        margin-bottom: 20px;
      }

      .order-details td { padding: 2px; font-size: 14px; }

      .table-order-item-details { 
        margin: auto; 
        width: 90%; 
        border: 1px solid #e3d0a8;
        border-collapse: collapse;
      }

      .table-order-item-details tr {
        border-bottom: 1px solid #e3d0a8;
      }

      .sub-details .col-item {
        width: auto;
        /* font-weight: 600; */
        padding-right: 10px;
        color: #696969	;
      }

      .col-item { width: 80%; }
      .col-price { width: 20%; text-align: right; padding-right: 10px; }

      .col-item ul {
        padding-left: 18px;

      }

      td { padding: 10px; font-size: 14px; }
      .item-name { font-weight: bold; }

      .backtohome {
        padding: 10px;
        background-color: #e3d0a8;
        margin: auto;
        text-decoration: none;
        color: #444;
        margin-top: 30px;
        margin-bottom: 20px;
        display: inline-block;
        width: auto;
      }

      footer {
        padding: 15px;
        background-color: #f1f1f1;
        font-size: 14px;
        color: #444;
      }

      footer > .contact-us > p {
        margin: 0 0 5px 0;
      }
    </style>
  </head>
  <body style="margin: 0">
      
    <header>
      <a href="{{ url('/') }}">
        <img src="{{ asset('img/logo/logo-negative.png') }}" alt="{{ env('APP_NAME') }}" />
        <span class="logo-text">
          <strong>{{ env('APP_NAME') }}</strong>
        </span>
      </a>
    </header>
        
    <div class="container">
      <div class="svg-green-tick">
        <?xml version="1.0" encoding="iso-8859-1"?>
        <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 367.805 367.805" style="enable-background:new 0 0 367.805 367.805;" xml:space="preserve">
        <g>
          <path style="fill:#3BB54A;" d="M183.903,0.001c101.566,0,183.902,82.336,183.902,183.902s-82.336,183.902-183.902,183.902
            S0.001,285.469,0.001,183.903l0,0C-0.288,82.625,81.579,0.29,182.856,0.001C183.205,0,183.554,0,183.903,0.001z"/>
          <polygon style="fill:#fff;" points="285.78,133.225 155.168,263.837 82.025,191.217 111.805,161.96 155.168,204.801 
            256.001,103.968 	"/>
        </g>
        </svg>
      </div>
      <h1 class="text-center">Order Successful!</h1>
      <p class="text-center">Hello <b>{{ $order->requirement->name }}</b></p>
      <hr/>
      <p class="text-center">Thank you for using our service. Your order details are as belows:</p>
      <hr/>
      <div class="order-details">
        <div class="sub-details">
          <table>
            <tbody>
              <tr>
                <td class="col-item">Order #: </td>
                <td>{{ $order->refNo }}</td>
              </tr>
              <tr>
                <td class="col-item">Order Date: </td>
                <td>{{ $order->created_at }}</td>
              </tr>
              <tr>
                <td class="col-item">Name: </td>
                <td>{{ $order->requirement->name }}</td>
              </tr>
              <tr>
                <td class="col-item">Email: </td>
                <td>{{ $order->requirement->email }}</td>
              </tr>
              <tr>
                <td class="col-item">Description: </td>
                <td>{{ $order->requirement->description }}</td>
              </tr>
              <tr>
                <td class="col-item">Translation: </td>
                <td>From {{ ucfirst($order->requirement->fromLang) }} to {{ ucfirst($order->requirement->toLang) }}</td>
              </tr>
              <tr>
                <td class="col-item">Delivery Date: </td>
                <td>{{ $order->created_at->addDays($order->items[0]->delivery_days) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      

      <table class="table-order-item-details">
        <tbody>
          @foreach ($order->items as $item)
            <tr>
              <td class="col-item">
                <span class="item-name">{{ $item->name }}</span>
                <div class="item-desc">
                  {{ $item->description }}
                </div>
              </td>
              <td class="col-price">{{ $currency }}{{ $item->unit_price }}</td>
            </tr>
            <tr>
              <td class="col-item text-right">Delivery Time: </td>
              <td class="col-price">{{ $item->delivery_days }} {{ $item->delivery_days > 1 ? 'Days' : 'Day' }}</td>
            </tr>
          @endforeach
          <tr>
            <td class="col-item text-right">Total: </td>
            <td class="col-price">{{ $currency }}{{ $order->total }}</td>
          </tr>
        </tbody>
      </table>

      <div class="text-center">
        <a class="backtohome" href="">Back To Site</a>
      </div>
      
    </div>
    

    <footer>
      <div class="contact-us text-center">
      <p>Contact us at <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">here</a> if you have any more enquires about your order.</p>
      </div>
      <div class="copyright text-center">
        &copy; 2020 Copyright <strong>{{ env('APP_NAME') }}</strong>. All Rights Reserved
      </div>
    </footer>
  </body>
</html>