<style>
  /* @page {
  size: A4 landscape;
  } */
  .body_ {
    font-family: "Lucida Console", "Courier New", monospace;
  }
  p {
    margin: 0.5rem 0;
  }
  .title_ {
    text-align: center;
  }
  .border_ {
    border: 1px solid;
  }
  table {
    margin: 1rem 0;
    width: 100%;
    border-collapse: collapse;
  }
  th {
    padding: 0.5rem 0;
    background-color: grey;
  }
  .center_ {
    text-align: center;
  }
  .right_ {
    text-align: right;
  }
</style>

<div class="body_">
  <table style="text-align: center">
    <tr>
      <td><h3>Panel Maker & Electrical Engineering</h3></td>
    </tr>
    <tr>
      <td>Jl. Imam Bonjol 332, Badung Bali</td>
    </tr>
    <tr>
      <td>Telp. 0361 8989 7632</td>
    </tr>
    <tr>
      <td>Email. naradaofficial@gmail.com</td>
    </tr>
  </table>
  <hr
    style="
      width: 80%;
      height: 2px;
      border-width: 0;
      color: gray;
      background-color: gray;
    "
  />
  <h2 class="title_">Purchase Order</h2>

  <table style="margin-bottom: 3rem">
    <tr>
        @foreach ($dataSupplier as $ds)
        <td>
            Kepada :
            <span style="font-weight: bold">{{ $ds->name }}</span>
        </td>
        @endforeach
      <td>
        Purchase Order No :
        <span style="font-weight: bold">{{ $codePO }}</span>
      </td>
    </tr>

    <tr>
        @foreach ($dataSupplier as $ds)
        <td>
            Alamat Supplier :
            <span style="font-weight: bold">{{ $ds->address }}</span>
        </td>
        @endforeach
      <td>
        <span style="font-weight: bold">PT. Narada Putra</span>
      </td>
    </tr>

    <tr>
      <td>
        Telepon :
        <span style="font-weight: bold">{{ $ds->phone }}</span>
      </td>
      <td>
        <span style="font-weight: bold">Jl. Imam Bonjol 332, Badung Bali</span>
      </td>
    </tr>

    <tr>
      <td>
        Nama Petugas:
        <span style="font-weight: bold">{{ $ds->officer }}</span>
      </td>
      <td>
        <span style="font-weight: bold">0361 8989 7632</span>
      </td>
    </tr>
  </table>

  <div style="width: 100%; display: flex; justify-content: center">
    <table style="width: 100%" class="border_">
      <tr>
        <th style="background-color: #27272a; color: white" class="border_">
          No
        </th>
        <th style="background-color: #27272a; color: white" class="border_">
          Nama
        </th>
        <th style="background-color: #27272a; color: white" class="border_">
          Qty
        </th>
        <th style="background-color: #27272a; color: white" class="border_">
          Satuan
        </th>
        <th style="background-color: #27272a; color: white" class="border_">
          Harga Satuan
        </th>
      </tr>

      @foreach ($dataMaterialPO as $dmp)
      <tr>
        <td class="center_ border_">{{ $loop->index + 1 }}</td>
        <td class="border_">{{ $dmp->material['name'] }}</td>
        <td class="center_ border_">{{ $dmp->qty }}</td>
        <td class="center_ border_">{{ $dmp->material->measurement['name'] }}</td>
        <td class="center_ border_" style="text-align: right">Rp. {{ number_format($dmp->price) }}</td>
      </tr>
      @endforeach

      @foreach ($dataMaterialPO as $dmp)
      <tr>
          <td colspan="3" style="border: none"> </td>
          <td style="font-weight: bold" class="border_">TOTAL</td>
          <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format($dmp->total_price) }}</td>    
      </tr>
      @endforeach

      @foreach ($dataBiayaPO as $dbp)
      <tr>
          <td colspan="3" style="border: none"> </td>
          <td style="font-weight: bold" class="border_">DISKON {{ $dbp->discount }}%</td>
          <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format(($dbp->discount*0.01) * $getTotalPrice) }} </td>    
      </tr>
      @endforeach

      <tr>
          <td colspan="3" style="border: none"> </td>
          <td style="font-weight: bold" class="border_">PPN 11%</td>
          <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format((11*0.01) * $getPriceAfterDisc) }} </td>    
      </tr>

      @foreach ($dataBiayaPO as $dbp)
      <tr>
          <td colspan="3" style="border: none"> </td>
          <td style="font-weight: bold" class="border_">GRAND TOTAL</td>
          <td style="font-weight: bold" class="right_ border_">Rp. {{ number_format($dbp->total_price) }}</td>    
      </tr>
      @endforeach

    </table>
  </div>
</div>
