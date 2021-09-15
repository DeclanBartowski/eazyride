$(document).ready(function () {
    let currentValues = {
            district: '',
            region: '',
            city: '',
        },
        arResult,
        addressList = $('.address-search-list'),
        regionSelect = $('[name=region]'),
        citySelect = $('[name=city]');
    BX.ajax.runComponentAction('2quick:addresses',
        'getCities', { // Вызывается без постфикса Action
            mode: 'class',
        })
        .then(function (response) {
            if (response.data.result) {
                arResult = response.data.result;
                if(response.data.current){
                    currentValues = {
                        district: response.data.current.UF_DISTRICT,
                        region: response.data.current.UF_REGION,
                        city: response.data.current.UF_XML_ID,
                    }
                    changeLocation();
                }
                $(document).on('change', '.tq_location_select', function () {
                    let $this = $(this);
                    currentValues[$this.attr('name')] = $this.val();
                    changeLocation()
                    return false
                })
            }
        });

    function changeLocation() {
        if (currentValues && arResult) {
            if (currentValues.district && typeof arResult[currentValues.district] != "undefined") {
                regionSelect.html('<option value="">Выбрать</option>');
                let selected = '';
                $.each(arResult[currentValues.district], function (index, value) {
                    if (currentValues.region === index) {
                        selected = ' selected';
                    } else {
                        selected = '';
                    }
                    regionSelect.append('<option value="' + index + '"' + selected + '>' + index + '</option>');
                })
                regionSelect.parent().prev().removeClass('lbl-disabled');
                regionSelect.attr('disabled', false);
                if (currentValues.region && typeof arResult[currentValues.district][currentValues.region] != "undefined") {
                    citySelect.html('<option value="">Выбрать</option>');
                    $.each(arResult[currentValues.district][currentValues.region], function (index, value) {
                        if (currentValues.city === value.UF_XML_ID) {
                            selected = ' selected';
                        } else {
                            selected = '';
                        }
                        citySelect.append('<option value="' + value.UF_XML_ID + '"' + selected + '>' + value.UF_NAME + '</option>');
                    })
                    citySelect.parent().prev().removeClass('lbl-disabled');
                    citySelect.attr('disabled', false);
                } else {
                    citySelect.parent().prev().addClass('lbl-disabled');
                    citySelect.attr('disabled', true);
                    currentValues.city = '';
                }
            } else {
                regionSelect.parent().prev().addClass('lbl-disabled');
                regionSelect.attr('disabled', true);
                citySelect.parent().prev().addClass('lbl-disabled');
                citySelect.attr('disabled', true);
                currentValues.city = '';
            }

        }
        $(".rev-select-box").RevSelectBox();
        $("select").RevSelectBox();
        addressList.html('');
        if (currentValues.city) {
            BX.ajax.runComponentAction('2quick:addresses',
                'getContacts', { // Вызывается без постфикса Action
                    mode: 'class',
                    data:{city:currentValues.city}
                })
                .then(function (response) {
                    if (response.data) {
                        addressList.html(response.data);
                    }
                });
        }
    }
})





