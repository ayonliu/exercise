# lua script

local template = require "resty.template"
local css = {
    '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">',
    '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css">',
    '<link rel="stylesheet" type="text/css" href="/css/main.css">'
}
local js = {'<script src="/js/vue.min.js" async=""></script>'}
template.render("view.html", {
    title = "test",
    message = "",
    css  = table.concat(css),
    js   = table.concat(js),
})

