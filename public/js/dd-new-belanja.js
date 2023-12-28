$(document).ready(function() {
    const addFormBelanja = $('#add-new-belanja');
    const formNewBelanja = $('#form-new-belanja');

    addFormBelanja.on('click', function() {
        const jumlahForm = $('.dd-new-belanja');
        const newBelanjaForm = formNewBelanja.children(':last').clone(true);

        const uniqueId = new Date().getTime(); 

        newBelanjaForm.attr('id', 'dd-new-belanja-' + uniqueId);

        newBelanjaForm.find('select, input').each(function() {
            const currentId = $(this).attr('id');
            if (currentId) {
                $(this).attr('id', currentId + '-' + uniqueId);
            }
        });

        formNewBelanja.append(newBelanjaForm);

        const removeKelengkapanButton = newBelanjaForm.find('.remove-form-pembelian');

        if (jumlahForm.length > 1) {
            removeKelengkapanButton.css('display', 'block');
        }

        removeKelengkapanButton.css('display', 'inline-block');
        removeKelengkapanButton.on('click', function() {
            newBelanjaForm.remove();
        });
    });
});
