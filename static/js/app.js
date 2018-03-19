(function () {
	'use strict';

	var $todoList = $(".js-component");
	var todoClient = new TodoClient();

	$todoList.on("click", ".js-remove-item", function (event) {
            removeItem( itemId(event) );
	});

    $todoList.on("click", ".js-toggle-item", function (event) {
            toggleItem( itemId(event) ); });

    $todoList.on("click", ".js-remove-completed", removeCompleted);

    $todoList.on("click", ".js-toggle-all", function (event) {
            markAll(!event.target.checked);
    });

    $todoList.on("click", ".js-toggle-all", function (event) {
            markAll(!event.target.checked);
    });

    function removeItem(id) {
        act(function() {
            todoClient
                .removeItem(id)
                .done(function(data) { updateState(data); })
        })
    }

    function toggleItem(id) {
        act(function() {
            todoClient
                .toggleItem(id)
                .done(function(data) { updateState(data); })
        })
    }

    function removeCompleted() {
        act(function() {
            todoClient
                .removeCompleted()
                .done(function(data) { updateState(data); })
        })
    }

    function markAll(yes) {
        act(function() {
            todoClient
                .markAll(yes)
                .done(function(data) { updateState(data); })
        })
    }

    function act(action) {
        $todoList.fadeTo(0, 0.5).css("pointer-events", "none");
        action();
        $todoList.fadeTo(0, 1).css("pointer-events", "");
    }

    function updateState($data) {
        $todoList.html($data);
    }

    function itemId(event) {
        var $removeButton  = $(event.target);
        var $itemContainer = $removeButton.closest(".js-item");

        return $itemContainer.attr("data-item-id");
    }

})();
