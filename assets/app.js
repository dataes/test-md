/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function () {
    // count the current form inputs
    var $blocksCollectionHolder = $('div.blocks');
    // set index
    $blocksCollectionHolder.data('index', $blocksCollectionHolder.find('input').length);

    $('body').on('click', '.add_item_link', function (e) {
        e.preventDefault();
        var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
        addFormsToCollection($collectionHolderClass);
    })

    function addFormsToCollection($collectionHolderClass) {
        // Get the ul that holds the collection of tags
        var $collectionHolder = $('.' + $collectionHolderClass + ':last');
        // Get the data-prototype
        var prototype = $collectionHolder.data('prototype');
        // get the new index
        var index = $collectionHolder.data('index');

        var newForm = prototype;
        // Replace '__name__' in the prototype's HTML to instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        var id = "newContent" + index;

        var $newFormLi = $('<div class="newContent" id=' + id + '></div>').append(newForm);
        $newFormLi.each(function () {
            addRemoveButton($(this));
        });
        // Add the new form at the end of the list
        $collectionHolder.append($newFormLi)
    }

    function addRemoveButton($block) {
        var $removeFormButton = $('<button type="button" class="btn btn-danger">Supprimer ce bloc</button>');
        $block.append($removeFormButton);
        $removeFormButton.on('click', function (e) {
            $block.remove();
        });
    }

    // flash message
    setTimeout(function () {
        $('#message').fadeOut('fast');
    }, 2000);

    // fix form control not focusable.
    $('textarea').each(function () {
        $(this).removeAttr('required');
    });
});