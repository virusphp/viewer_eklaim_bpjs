<!-- Attachment Modal -->
<div class="modal fade" id="modal-sep" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-md-4">
        <h5 class="modal-title" id="edit-modal-sep">Surat Eligibilitas Peserta </h5>
      </div>
      <div class="col-md-4">
        <!-- <input class="form-control-plaintext" type="text" id="tglSep" nama="tgl_reg" readonly> -->
      </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="attachment-body-content">
      <form id="form-sep" action="" class="form-horizontal" method="POST">
        <div id="frame_error" class="alert alert-danger">
            <!-- error message -->
        </div>
      
        <div class="row">
            <!-- profile -->
              <div class="col-sm-4">
                <div class="card">
                  <div class="card-header">
                    <strong>Profil</strong>
                    <small>Pasien</small>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                        <label for="vat">No Registrasi</label>
                        <input class="form-control form-control-sm" id="no_reg" name="no_reg" type="text" placeholder="No Registrasi" readonly>
                    </div>
                    <div class="form-group">
                      <label for="company">No KTP</label>
                      <input class="form-control form-control-sm" id="no_ktp" type="text" placeholder="No KTP" readonly>
                      <input class="form-control form-control-sm" name="_token" type="hidden" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group">
                      <label for="street">Nama Pasien</label>
                      <input class="form-control form-control-sm" id="nama_pasien" type="text" placeholder="Nama Pasien" readonly>
                    </div>
                    <div class="form-group">
                      <label for="vat">Tanggal Lahir</label>
                      <input class="form-control form-control-sm" id="tgl_lahir" type="text" placeholder="Tanggal Lahir" readonly>
                    </div>
                    <div class="form-group">
                        <label for="city">Hak Kelas</label>
                        <input class="form-control form-control-sm" id="kelas" name="namaKelas" type="text" placeholder="kelas" readonly>
                    </div>
                    <div class="form-group">
                        <label for="aktif">Peserta</label>
                        <input class="form-control form-control-sm" id="aktif" type="text" placeholder="Aktif/NON Aktif" readonly>
                    </div>
                    <div class="form-group">
                        <label for="city">Jenis Pelayanan</label>
                        <input class="form-control form-control-sm" id="nama_pelayanan" type="text" placeholder="Jenis Pelayanan" readonly>
                        <input class="form-control form-control-sm" id="jns_pelayanan" name="jnsPelayanan" type="hidden">
                    </div>
                  </div>
                </div>
              </div>
              <!-- profile -->
            <div id="data-post-sep" class="col-sm-8">
                <div class="card">
                  <div class="card-header">
                    <strong>Pembuatan SEP</strong>
                    <small>Data insert SEP </small>
                  </div>
                  <div class="card-body">
                   <div class="row">
                        <div class="col-sm-4">
                            <div id="form-kartu" class="form-group">
                                <label id="no-sep" for="no_kartu">No Kartu</label>
                                <input type="text" class="form-control form-control-sm" id="no_kartu" name="noKartu" placeholder="No Kartu" readonly>
                                <input type="hidden" class="form-control form-control-sm" id="noSep" name="noSep" readonly>
                                <input type="hidden" class="form-control form-control-sm" id="tglSep" name="tglSep" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" id="c_cob" type="checkbox" value="0">
                                    <label class="form-check-label" for="c_cob">Cob | No RM</label>
                                </div>
                                <input class="form-control form-control-sm" id="no_rm" name="noMR" type="text" placeholder="No RM" readonly>
                                <input class="form-control form-control-sm" id="cob" name="cob" type="hidden" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vat">Tanggal Rujukan</label>
                                <!-- <input class="form-control form-control-sm" id="tgl_rujukan" name="tglRujukan" type="text" placeholder="No Registrasi" readonly> -->
                                <div class="input-group date {{ $errors->has('tglRujukan') ? 'has-error' : '' }}" id="dtgl_rujukan" >
                                        <div class="input-group-append">
                                            <span class="input-group-text input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>                        
                                        <input class="form-control form-control-sm" id="tgl_rujukan" 
                                                value="{{ date('Y-m-d')}}" 
                                                placeholder="Tanggal Kejadian" name="tglRujukan"
                                                type="text"
                                                data-date-format='YYYY-MM-DD'/>
                                    </div>
                            </div>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-sm-4">
                            <div id="k-rujukan" class="form-group">
                                <div>
                                    <label for="no_rujukan">No Rujukan</label>
                                    <input class="btn btn-ghost-primary btn-cus" id="cari_rujukan" type="button" value="cari">
                                    <input class="btn btn-ghost-primary btn-cus float-right" id="cari_sko" type="button" value="sko">
                                </div>
                                <input class="form-control form-control-sm" id="noRujukan" name="noRujukan" type="text" placeholder="No Rujukan" tabindex="1" autofocus>
                            </div>
                            <input class="form-control form-control-sm" id="intern_rujukan" type="hidden" value='0'>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="nama_faskes">Asal Rujukan</label>
                                <select id="asalRujukan" name="asalRujukan" class="form-control form-control-sm">
                                        <option value="1">Faskes Tingkat 1</option> 
                                        <option value="2">Faskes Tingkat 2</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diagnosa">PPK Asal Rujukan</label>
                                <input class="form-control form-control-sm" id="nama_faskes" name="namaFaskes" type="text" placeholder="PPK Asal Rujukan">
                                <!-- <input class="form-control form-control-sm" id="tgl_rujukan" name="tglRujukan" type="hidden">  -->
                                <input type="hidden" class="form-control form-control-sm" id="ppk_rujukan" name="ppkRujukan" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diagnosa">Diagnosa</label>
                                <input class="form-control form-control-sm" id="diagAwal" name="diagnosa" maxLengh="3" tabindex="2" type="text" placeholder="Diagnosa Awal">
                                <input class="form-control form-control-sm" id="kd_diagnosa" name="diagAwal" type="hidden">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" id="c_eksekutif" type="checkbox" value="0">
                                    <label class="form-check-label" for="poli">Eksekutif | Spe / SubSpesialis</label>
                                </div>
                                <input class="form-control form-control-sm" id="tujuan" name="poli" type="text" tabindex="3" placeholder="Nama Poli">
                                <input class="form-control form-control-sm" id="kd_poli" name="tujuan" type="hidden" readonly>
                                <input class="form-control form-control-sm" id="eksekutif" name="eksekutif" type="hidden" value="0" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="diagnosa">No Telp</label>
                                <input class="form-control form-control-sm" id="noTelp" name="noTelp" type="text" tabindex="4" placeholder="No Telp">
                            </div>
                        </div>
                    </div>
                    <div id="form-skdp" class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="no_surat">Surat Kontrol</label>
                                <input class="form-control form-control-sm" id="noSurat" name="noSurat" type="text" tabindex="5" placeholder="Ketik no surat kontrol" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="6">
                                <input class="form-control form-control-sm" id="noSuratLama" type="hidden" tabindex="5">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="kd_dpjp">DPJP Pemberi Surat SKDP</label>
                                <input class="form-control form-control-sm" id="kodeDPJP" name="dokterDPJP" type="text" tabindex="6" placeholder="Ketik Nama Dokter DPJP">
                                <!-- <select id="kodeDPJP" name="kodeDPJP" class="form-control form-control-sm"></select> -->
                                <input class="form-control form-control-sm" id="kd_dpjp" name="kodeDPJP" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control form-control-sm" id="catatan" name="catatan" type="text" tabindex="7 "placeholder="Catatan"></textarea>
                    </div>
                    <div class="form-group" id="form-katarak">
                        <div class="form-check checkbox">
                            <input class="form-check-input" id="c_katarak" type="checkbox" value="0">
                            <label class="form-check-label" for="c_katarak">Katarak</label>
                        </div>
                        <input class="form-check-input" id="katarak" name="katarak" type="hidden" value="0">
                        <input class="form-control form-control-sm" type="text" placeholder="Centang Katarak, Jika pasien tersebut mendapat surat operasi Katarak" readonly>
                    </div>
                    <!-- Penjamin -->
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" id="c_penjamin" type="checkbox" value="0">
                                    <label class="form-check-label" for="c_penjamin">Penjamin Kll</label>
                                </div>
                                <input class="form-check-input" id="lakalantas" name="lakaLantas" type="hidden" value="0">
                                <input class="form-check-input" id="penjamin" name="penjamin" type="hidden" value="0">
                                <input type="hidden" class="form-control form-control-sm" id="suplesi" name="suplesi" value="0">
                                <input type="hidden" class="form-control form-control-sm" id="no_suplesi" name="noSepSuplesi" value="0">
                            </div>
                        </div>
                        <div id="form-penjamin1" class="col-sm-8">
                            <div class="form-group">
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" name="penjamin[]" id="inline-checkbox1" type="checkbox" value="1">
                                    <label class="form-check-label" for="inline-checkbox1">Jasa Raharja</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" name="penjamin[]" id="inline-checkbox2" type="checkbox" value="2">
                                    <label class="form-check-label" for="inline-checkbox2">BPJS KetenagaKerjaan</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" name="penjamin[]" id="inline-checkbox3" type="checkbox" value="3">
                                    <label class="form-check-label" for="inline-checkbox3">Taspen</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" name="penjamin[]" id="inline-checkbox4" type="checkbox" value="4">
                                    <label class="form-check-label" for="inline-checkbox4">ASABRI</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="form-penjamin2">
                        <!-- Tanggal -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group date {{ $errors->has('tgl') ? 'has-error' : '' }}" id="dtgl_kejadian" >
                                        <div class="input-group-append">
                                            <span class="input-group-text input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>                        
                                        <input class="form-control form-control-sm" id="tgl_kejadian" 
                                                value="{{ date('d-m-Y')}}" 
                                                placeholder="Tanggal Kejadian" name="tglKejadian"
                                                type="text"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div clss="lokasi-header">Lokasi Kejadian</div>
                        <div class="form-group row">
                            <div class="col-4">
                                <div class="input-group">
                                    <select id="provinsi" name="kdPropinsi" class="form-control">
                                        <option value="0">Pilih</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <select id="kabupaten" name="kdKabupaten" class="form-control">
                                        <option value="0">Pilih</option> 
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <select id="kecamatan" name="kdKecamatan" class="form-control">
                                        <option value="0">Pilih</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control form-control-sm" id="ket_kill" name="keterangan" type="text" placeholder="Keterangan"></textarea>
                        </div>
                    </div>

                  </div>
                </div>
              </div>
        </div>
      </div>
    </form>
      <div class="modal-footer">
        <input id="cetak-sep" type="button" class="btn btn-sm btn-primary" tabindex="8" value="Cetak SEP">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /Attachment Modal -->

<!-- modal Rujukan-->
<div class="modal" id="modal-rujukan" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label-2" aria-hidden="true">
<div class="modal-dialog modal-md modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label"><strong>Pilih Rujukan Aktif</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbl-rujukan" class="table table-responsive-sm table-bordered table-striped table-sm">
            <thead>
                 <tr>
                    <th>No</th>
                    <th>No Rujukan</th>
                    <th>Tgl Rujukan</th>
                    <th>No Kartu</th>
                    <th>Nama</th>
                    <th>PPK Perujuk</th>
                    <th>Sub/Speliasis</th>
                </tr>
            </thead>
            <tbody>
                    
            </tbody>
        </table>
       
      </div>
    </div>
  </div>
</div>

<!-- modal Sep -->
<div class="modal" id="modal-history" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label-2" aria-hidden="true">
<div class="modal-dialog modal-md modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label"><strong>Pilih Sep Sebagai Rujukan SKO/SPO</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbl-history" class="table table-responsive-sm table-bordered table-striped table-sm">
            <thead>
                 <tr>
                    <th>No</th>
                    <th>No Rujukan</th>
                    <th>Tgl Rujukan</th>
                    <th>No Kartu</th>
                    <th>Nama</th>
                    <th>PPK Perujuk</th>
                </tr>
            </thead>
            <tbody>
                    
            </tbody>
        </table>
       
      </div>
    </div>
  </div>
</div>