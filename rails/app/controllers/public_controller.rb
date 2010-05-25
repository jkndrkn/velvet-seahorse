class PublicController < ApplicationController
    layout 'public'

    ITEM_MAX_BODY = 13
    ITEM_MAX_EYES = 13

    def index
    end

    def news
    end

    def body
        gallery_generate("body", ITEM_MAX_BODY, params[:current])
    end
    
    def eyes
        gallery_generate("eyes", ITEM_MAX_BODY, params[:current])
    end

    def about
    end
    
    def curiosity
    end

    def cv
        filename = "melanie-brewster-cv.pdf"
        send_file("#{RAILS_ROOT}/public/#{filename}", :type => "application/pdf")
    end

    def gallery_generate(name, items_max, item_current)
        item_current = gallery_clamp_values(items_max, item_current)
        html = @template.image_tag("#{name}/#{item_current}.JPG")
        html << gallery_generate_nav(name, items_max, item_current).html_safe
        @gallery = html
    end

    def gallery_generate_nav(name, items_max, item_current)
        previous = item_current > 1 ? item_current - 1 : nil
        next_ = item_current < items_max ? item_current + 1 : nil

        previous_html = previous ? @template.link_to("&laquo;", {:action => "body", :current => previous}) : "&laquo;"
        next_html = next_ ? @template.link_to("&raquo;", {:action => "body", :current => next_}) : "&raquo;"

        html = "<div id=\"nav-gallery\">#{previous_html} #{item_current} of #{items_max} #{next_html}</div>"

        html
    end

    def gallery_clamp_values(items_max, item_current)
        item_current = item_current.to_i
        item_current = (item_current > items_max) ? items_max : item_current
        item_current = (item_current < 1) ? 1 : item_current
        item_current 
    end
end
