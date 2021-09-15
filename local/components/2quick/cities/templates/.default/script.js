$(document).ready(function () {
    let currentValues = {
            district: '',
            region: '',
            city: '',
        },
        arResult,
        regionList = $('#city_region_list'),
        cityList = $('#city_list_block');
    BX.ajax.runComponentAction('2quick:cities',
        'getCities', { // Вызывается без постфикса Action
            mode: 'class',
        })
        .then(function (response) {
            if (response.data) {
                arResult = response.data;
                $(document).on('click','[data-city-object]',function (){
                    let $this = $(this);
                    $this.closest('ul').find('a').removeClass('act');
                    $this.addClass('act');
                    currentValues[$this.data('city-object')] = $this.data('id');
                    changeLocation();
                })
            }
        });

    function changeLocation() {
        if (currentValues && arResult) {
            if (currentValues.district && typeof arResult[currentValues.district] != "undefined") {
                regionList.html('');
                let selected = '';
                $.each(arResult[currentValues.district], function (index, value) {
                    if (currentValues.region === index) {
                        selected = ' class="act"';
                    } else {
                        selected = '';
                    }
                    regionList.append('<li><a' + selected + ' data-city-object="region" data-id="' + index + '" href="javascript:void(0)">' + index + '</a></li>');
                })
                if (currentValues.region && typeof arResult[currentValues.district][currentValues.region] != "undefined") {
                    cityList.html('');
                    $.each(arResult[currentValues.district][currentValues.region], function (index, value) {

                        cityList.append('<li><a href="/' + value.UF_SUB_DOMAIN + '/">' + value.UF_NAME + '</a></li>');
                    })

                } else {
                    currentValues.city = '';
                }
            } else {
                currentValues.city = '';
            }

        }
    }

    $(document).on('submit', '#city_search_form', function () {
        let $this = $(this),
            cityList = $('#city_list');
        cityList.remove();
        BX.ajax.runComponentAction('2quick:cities',
            'search', { // Вызывается без постфикса Action
                mode: 'class',
                data: {query: $this.find('[name=query]').val()}
            })
            .then(function (response) {
                if (response.data) {
                    $this.after(response.data);
                }
            });
        return false;
    })
})





