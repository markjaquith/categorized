jQuery ($) ->
	app =
		default: cwsCategorizedDefault,
		checklist: $ 'ul.categorychecklist, .wp-list-table.posts tbody'
		otherCatsChecked: ->
			i = $('li input[type="checkbox"]:checked', @checklist).not("input[value=\"#{@default}\"]")
			@log i
			i
		init: ->
			@listen() unless @otherCatsChecked().length > 0
		log: (message) ->
			# console.log message
		listen: ->
			@log 'listening'
			# Yes, :checked. By the time we get the click event, it is already checked
			nonDefaults = @checklist.on 'click', 'input[type="checkbox"]:checked', (e) =>
				@log 'click'
				i = $ e.currentTarget

				# Bail if other non-default categories are already checked
				return if @otherCatsChecked().not(i).length > 1
				@log 'no non-default categories checked'

				# Ignore clicks on the default category
				return if i.attr('value') is @default
				@log 'was not a default category click'

				# Still here? Uncheck the default category
				$("input[type=\"checkbox\"][value=\"#{@default}\"]", @checklist).prop 'checked', ''
	# Start it up
	app.init()