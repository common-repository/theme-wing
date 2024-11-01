jQuery(document).ready( function( $ ) {
    "use strict"
    var container = $( ".theme-wing-meta-box-wrap" );

    // change the position of selected icon at front
    container.find( ".meta-icon-picker-field" ).each(function() {
        var iconList = $(this).find( ".icons-list" );
        iconList.find( "i.selected" ).prependTo( iconList );
    })
    container.on( "keyup", ".meta-icon-picker-field .search-field input", function() {
        var listContainer  = $(this).parent().next();
        var toSearch = $(this).val();
        if( toSearch ) {
            listContainer.find( "i" ).each( function() {
                if( $(this).attr( "class" ).indexOf( toSearch ) > 0 ) {
                    $(this).show()
                } else {
                    $(this).hide()
                }
            })
        } else {
            listContainer.find( "i" ).show();
        }
    })
    // fontawesome icon picker handler
    container.on( "click", ".meta-icon-picker-field .icon-header", function() {
        var _this = $(this)
        _this.find( ".icon-list-trigger i" ).toggleClass( "fa-angle-down fa-angle-up" );
        _this.siblings().slideToggle();
    })
    // icon picker in meta handler
    container.on( "click", ".meta-icon-picker-field .icons-list i", function() {
        var _this = $(this)
        if( ! _this.hasClass( "selected" ) ) {
            var newValue = _this.attr( "class" );
            _this.removeClass( "selected" ).addClass( "selected" ).siblings().removeClass( "selected" );
            _this.parent().next().val( newValue );
            _this.parent().siblings( ".icon-header" ).find( "i" ).first().removeClass().addClass( newValue );
            if(_this.parents( ".meta-repeater-control" ).length > 0 ) theme_wing_refresh_repeater_values( _this )
        }
    })

    // handle repeater fields
    container.find( ".meta-repeater-control" ).each(function() {
        $(this).on( "change keyup", ".repeater-item .repeater-field-single-meta-value", function() {
            var _this =$(this)
            theme_wing_refresh_repeater_values( _this )
        })
        $(this).on( "click", ".repeater-item .add-item", function() {
            var _this = $(this), toClone = _this.parent()
            var cloned = toClone.clone()
            cloned.find( ".remove-item" ).show();
            toClone.after( cloned )
            theme_wing_refresh_repeater_values( _this )
        })

        $(this).on( "click", ".repeater-item .remove-item", function() {
            var _this = $(this), toRemove = _this.parent(), parent = _this.parents( ".single-repeater-control" )
            toRemove.slideUp('slow', function() {
                toRemove.remove();
                theme_wing_refresh_repeater_values( parent )
            })
        })
    })
    function theme_wing_refresh_repeater_values( _this ) {
        var parent = ( _this.hasClass( "meta-repeater-control" ) ) ? _this : _this.parents( ".meta-repeater-control" ), valueToAssignEl = parent.find( ".repeater-field-meta-value" )
        var controlValue = []
        parent.find( ".repeater-item" ).each(function() {
            var newValue = {}
            $(this).find( ".repeater-field-single-meta-value" ).each(function() {
                var singleKey = $(this).data( "key" ), singleVal = $(this).val()
                newValue[singleKey] = singleVal
            })
            controlValue.push( newValue )
        })
        valueToAssignEl.val( JSON.stringify( controlValue ) )
    }
})