function formatAngka(angka) {
    return accounting.formatMoney(angka, "", 0, ".", ",");
}

document.addEventListener('alpine:init', () => {
    Alpine.store('estimasiBiaya', {
        itemCount: 0,
        estimasis: [],

        addItem() {
            this.itemCount++;
            this.estimasis.push({
                id: this.itemCount,
                jenisTransaksi: '',
                jenisFilteredItems: [],
                namaFilteredItems: [],

                namaAlias: '',
                hargaCustomer: '',
                hargaCustomerFormatted: '',
                stokPart: '',
                hargaPromoPart: '',
                hargaRepair: '',
                hargaGudang: '',
                modalGudang: '',

                jenisDrone: '',
                jenisDroneOptions: [],
                namaPart: '',
                namaPartOptions: [],
                jenisSearch: '',
                namaSearch: '',
                showJenisDropdown: false,
                showNamaDropdown: false,
                jenisId: '',
                namaId: '',
            });
        },

        removeItem(id) {
            this.estimasis = this.estimasis.filter(item => item.id !== id);
        },

        get isButtonDisabled() {
            return this.estimasis.length === 0;
        },

        formatRupiah(angka) {
            return accounting.formatMoney(angka, "Rp. ", 0, ".", ",");
        },

        formatAngka(angka) {
            if (!angka) return '';
            return accounting.formatMoney(angka, "", 0, ".", ",");
        },

        parseAngka(str) {
            if (!str) return 0;
            return parseInt(str.replace(/\./g, '')) || 0;
        },

        get totalBiaya() {
            return this.estimasis.reduce((sum, item) => {
                const numeric = parseFloat(String(item.hargaCustomer).replace(/\D/g, '')) || 0;
                return sum + numeric;
            }, 0);
        },

        onJenisTransaksiChange(item) {
            const selected = item.jenisTransaksi;

            item.jenisDroneOptions = [];
            item.namaPartOptions = [];

            item.jenisId = '';
            item.jenisSearch = '';
            item.jenisFilteredItems = [];

            item.namaId = '';
            item.namaSearch = '';
            item.namaFilteredItems = [];

            item.namaAlias = '';
            item.hargaCustomer = '';

            if (selected == 1 || selected == 2) {
                item.jenisDroneOptions = [];
                item.jenisDrone = '';
                item.namaPartOptions = [];
                item.namaPart = '';

                fetch(`/repair/estimasi/jenisDrone`)
                    .then(response => response.json())
                    .then(data => {
                        item.jenisDroneOptions = data.map(d => ({
                            value: d.id,
                            label: d.jenis_produk
                        }));

                        item.jenisFilteredItems = [...item.jenisDroneOptions];
                    });
            } else {
                item.jenisFilteredItems = [];
                item.jenisDroneOptions = [];
                item.jenisDrone = '';
                item.namaPartOptions = [];
                item.namaPart = '';
            }
        },

        searchItems(item, type) {
            if (type === 'jenis') {

                item.jenisFilteredItems = item.jenisDroneOptions.filter(option => 
                    option.label.toLowerCase().includes(item.jenisSearch.toLowerCase())
                );
            } else if (type === 'nama') {
                item.namaFilteredItems = item.namaPartOptions.filter(option => 
                    option.label.toLowerCase().includes(item.namaSearch.toLowerCase())
                );
            }
        },

        selectJenis(item, option) {
            item.jenisSearch = option.label;
            item.jenisId = option.value;
            item.showJenisDropdown = false;

            this.onJenisDroneChange(item);
        },

        async onJenisDroneChange(item) {
            const jenisDroneId = item.jenisId;
            if (!jenisDroneId) return;
        
            // Fetch part berdasarkan jenis drone
            fetch(`/repair/estimasi/getPartGudang/${jenisDroneId}`)
                .then(response => response.json())
                .then(data => {
                    item.namaPartOptions = data.map(p => ({
                        value: p.id,
                        label: p.nama_internal
                    }));

                    item.namaFilteredItems = [...item.namaPartOptions];
                });
        },

        selectNama(item, option) {
            item.namaSearch = option.label;
            item.namaId = option.value;
            item.showNamaDropdown = false;

            this.onNamaPartChange(item);
        },

        async onNamaPartChange(item) {
            const partId = item.namaId;
            if (!partId) return;

            fetch(`/repair/estimasi/getDetailGudang/${partId}`)
                .then(response => response.json())
                .then(data => {
                    item.stokPart = data.stock || 0;
                    item.hargaRepair = formatAngka(data.detail.harga_internal) || 0;
                    item.hargaGudang = formatAngka(data.detail.harga_global) || 0;
                    item.hargaPromoPart = formatAngka(data.detail.harga_promo) || 0;
                });
        },
    });
});

$(document).ready(function () {

    $(document).on('input', '.format-angka-estimasi', function () {
        var inputActive = $(this).val();
        inputActive = inputActive.replace(/[^\d]/g, '');
        var parsedNumber = parseInt(inputActive, 10);
        $(this).val(formatAngka(parsedNumber));
    });

});