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
  <h2 class="title_">Surat Jalan</h2>

  <table style="margin-bottom: 3rem">
    <tr>
      <td>
        No Kontrak Customer :
        <span style="font-weight: bold">{{ $contractCode }}</span>
      </td>

      @foreach ($dataCustomer as $dc)
      <td>
        Alamat Pengiriman :
        <span style="font-weight: bold">{{ $dc->customer['address'] }}</span>
      </td>
      @endforeach
    </tr>
    <tr>
      @foreach ($dataCustomer as $dc)
      <td>
        Alamat Pengiriman :
        <span style="font-weight: bold">{{ $dc->customer['name'] }}</span>
      </td>
      @endforeach
      <td>
        Tanggal Pegiriman :
        <span style="font-weight: bold">{{ $dateSuratJalan }}</span>
      </td>
    </tr>
    <tr>
      <td>
        Tanggal Buat SJ :
        <span style="font-weight: bold">{{ $dateSuratJalan }}</span>
      </td>
      <td>
        Surat Jalan No : <span style="font-weight: bold">2002.11.SJ.0001</span>
      </td>
    </tr>
    <tr>
      <td>
        Nomor Kendaraan :
        <span style="font-weight: bold">{{ $plateNumber }}</span>
      </td>
      <td>

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
          Satuan
        </th>
        <th style="background-color: #27272a; color: white" class="border_">
          Qty
        </th>
      </tr>

      @foreach ($dataBarang as $db)
      <tr>
        <td class="center_ border_">{{ $loop->index + 1 }}</td>
        <td class="border_">{{ $db->set_good['name'] }}</td>
        <td class="center_ border_">{{ $db->qty }}</td>
        <td class="center_ border_">{{ $db->set_good->measurement['name'] }}</td>
      </tr>
      @endforeach

    </table>
  </div>
</div>
