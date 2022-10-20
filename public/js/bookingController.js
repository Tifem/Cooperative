/**
 * Start Bookings Form Handlers
 */


const $form = $('#bookings-form');
const btn = $form.find('[data-ktwizard-type="action-submit"]');

let loading = false;
const toggleLoader = () => {
    if (!loading) {
        KTApp.progress(btn);
        KTApp.block($form);
        loading = true;
        return;
    }

    KTApp.unprogress(btn);
    KTApp.unblock($form);
    loading = false;
};

const processFormInputs = serializedData => {
    const processRepeatedValues = serializedData.filter(data => data.name.includes('['));

    const processedRepeatedValuesArray = [],
        valuesObject = {};

    processRepeatedValues.forEach(value => {
        const repeatedVal = value.name,
            regexForName = /[a-zA-Z_]/gm,
            regexForIndex = /[0-9]/g,
            name = repeatedVal.match(regexForName).join(''),
            index = parseInt(repeatedVal.match(regexForIndex).join('')),
            newValuesObject = {
                ...valuesObject,
                name,
                value: value.value
            };
        processedRepeatedValuesArray.push(newValuesObject);
    });

    const mergeArrays = serializedData
        .filter(data => !data.name.includes('['))
        .concat(processedRepeatedValuesArray);

    return mergeArrays
        .map(data => ({[data.name]: data.value}))
        .reduce((accumulator, current) => {
                const currentVal = Object.values(current),
                    currentKey = Object.keys(current),
                    previousVal = accumulator[currentKey[0]];

                let currentData = current;

                if (currentKey[0] in accumulator)
                    currentData[currentKey[0]] = [
                        previousVal,
                        currentVal[0]
                    ];

                return {
                    ...accumulator,
                    ...currentData,
                }
            }
        );
};

$form.on('submit', async function (e) {
    e.preventDefault();

    toggleLoader();

    const serializedData = $(this).serializeArray();

    const processedArray = processFormInputs(serializedData);

    try {
        const postRequest = await request("/bookings/store", processedArray, 'post');
        toggleLoader();
        $form.trigger('reset');

        swal.fire({
            "title": "",
            "text": postRequest.message,
            "type": "success",
            "confirmButtonClass": "btn btn-secondary"
        });

    } catch (e) {
        toggleLoader();
        if ('message' in e) {
            swal.fire({
                "title": "",
                "text": e.message || "",
                "type": "error",
                "confirmButtonClass": "btn btn-secondary"
            });
        }
    }
});

/**
 * End Bookings Form Handlers
 */

/**
 * Start Bookings Table Handlers
 */



/**
 * End Bookings Table Handlers
 */


/**
 * Start Bookings Delete Handlers
 */

function deleteBooking(id) {
    const toggleDeleteLoader = () => {
        const $deleteIcon = document.getElementById(`#delete-icon-${id}`);
        console.log(`#delete-icon-${id}`, $deleteIcon);
        const $originalClass = $deleteIcon.className;

        $deleteIcon.className = "fa fa-spinner fa-spin";
        setTimeout(() => {
            $deleteIcon.className = $originalClass;
        }, 3000);
    };

    toggleDeleteLoader()

    // try {
    //     const deleteRequest = await request("/bookings/delete/" + id, null, 'delete');
    //
    //     swal.fire({
    //         "title": "Success",
    //         "text": deleteRequest.message,
    //         "type": "success",
    //         "confirmButtonClass": "btn btn-secondary"
    //     });
    //
    // } catch (e) {
    //     if ('message' in e) {
    //         swal.fire({
    //             "title": "",
    //             "text": e.message || "",
    //             "type": "error",
    //             "confirmButtonClass": "btn btn-secondary"
    //         });
    //     }
    // }
}

/**
 * End Bookings Delete Handlers
 */
