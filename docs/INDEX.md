# Package Documentation: Overview & Index

This folder contains documentation for the package's public and internal classes, utilities, middleware and console helpers derived from the code under `src/` and related package files.

## How the docs are organized

- Root-level documents (overview, exceptions, middleware, plans, facade reference).
- `Libraries/`: HTTP clients and utility libraries (ContentSplitter, Gateway client).
- `Containers/`: container utilities for Website/XML/RSS/Sitemap generation.
- `Cores/`: core classes and helpers used by container and service logic.
- `Commands/`: console command documentation (environment build command).

## Index

- Root documents
    - [Middleware.md](Middleware.md): Consolidated middleware reference listing available middleware and usage examples
    - [TMGBlade.md](TMGBlade.md): Facade/helper reference for Blade integration and rendering analytics/advertising snippets
    - [Exceptions.md](Exceptions.md): Consolidated exceptions table describing package-specific exceptions and typical causes
    - [Plans.md](Plans.md): Scheduled task (Plan) documentation explaining how to write and register Plan classes
- Cores
    - [Cores/ModelOrm.md](Cores/ModelOrm.md): Lightweight ORM-like helper for mapping raw data into model arrays/objects
    - [Cores/Presenter.md](Cores/Presenter.md): Presentation helpers to format and serialize items
    - [Cores/Seeker.md](Cores/Seeker.md): Query and lookup helper for searching and extracting items from sources
    - [Cores/Operator.md](Cores/Operator.md): Maintains core operations for storing, retrieving, and manipulating items
    - [Cores/Supplier.md](Cores/Supplier.md): Data supplier abstraction to fetch or provide item lists to containers
    - [Cores/Gatherer.md](Cores/Gatherer.md): Argument gathering and normalization helper for processing input parameters
- Containers
    - [Containers/Container.md](Containers/Container.md): Base container class and shared behaviors for output generators
    - [Containers/WebContainer.md](Containers/WebContainer.md): Website container helpers for HTML/web-oriented output formats
    - [Containers/ApiContainer.md](Containers/ApiContainer.md): API-focused container for producing structured JSON or API payloads
    - [Containers/XmlContainer.md](Containers/XmlContainer.md): XML generation utilities and usage examples for XML outputs
    - [Containers/RssContainer.md](Containers/RssContainer.md): RSS generation container with item formatting and feed options
    - [Containers/SitemapContainer.md](Containers/SitemapContainer.md): Sitemap builder for individual sitemap generation and item entries
    - [Containers/SitemapIndexContainer.md](Containers/SitemapIndexContainer.md): Sitemap index builder for aggregating multiple sitemap files
- Libraries
    - [Libraries/GatewayClient.md](Libraries/GatewayClient.md): HTTP client wrapper for interacting with the Gateway service
    - [Libraries/ContentSplitter.md](Libraries/ContentSplitter.md): Utility to split content into keyword-focused segments for analysis or display
- Commands
    - [Commands/env.build.md](Commands/env.build.md): Env build console command documentation describing usage and options
