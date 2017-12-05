# lua script

local template = require "resty.template"
template.render("view.html", {
    title = "test",
    message = "Hello, World!",
    css  = '<script src="css/bootstrap.min.css"></script>'
})
