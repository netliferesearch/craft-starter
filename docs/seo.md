# SEO in Craft CMS

[SEOmatic](https://plugins.craftcms.com/seomatic) is included in this project by default. It has a straight-forward UI for how to
set up SEO for sections and globally. It's a paid plugin, but it's usually something we recommend our client to buy since it makes it possible for
them to update and control some SEO-parameters without a developer.

## Built-in

If a client doesn't want to use/pay for SEOmatic you can create two new files in
your templates-directory, for `robots.txt` and `sitemap.xml`. These are simple
examples of what it can look like.

### `robots.txt`

```twig
{% header 'Content-Type: text/plain; charset=utf-8' %}User-agent: * Disallow:
/admin/{% if getenv('CRAFT_ENVIRONMENT') == 'production' %}
  Allow: /
{% endif %}
```

### `sitemap.xml`

```twig
<urlset>
  {% for section in craft.app.sections.getAllSections() %}
    {% for entry in craft.entries.sectionId(section.id).limit(null).all() %}
      <url>
        <loc>
          {{ entry.url }}
        </loc>
      </url>
    {% endfor %}
  {% endfor %}
</urlset>
```
