

(function( $ ) {

	'use strict';

	var datatableInit = function() {

		$('#datatable-default').dataTable();
		$('#datatable-default2').dataTable();
		$('#datatable-default3').dataTable();
		$('#datatable-default4').dataTable();

	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);