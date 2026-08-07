-- FreelanceNearMe Phase 0 spike — Mercur (Medusa v2) schema dump
-- Generated Fri Aug  7 06:59:43 PM UTC 2026 from database 'mercur_spike'
-- Mercur @mercurjs/core 2.3.0-canary.0 on @medusajs 2.17.2
-- Scope: vendor(seller)/product/order/payment + marketplace (offer/commission/payout/review) tables
-- Full public schema has 200 tables; this dump covers the domain-relevant subset.

--
-- PostgreSQL database dump
--

\restrict 43m5dgRUeg4AgzspfaEjou62Yf1RZ4la0nvhBC1yD8TE2i9z3XgkVr7QnT4iEwe

-- Dumped from database version 16.14 (Ubuntu 16.14-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.14 (Ubuntu 16.14-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: capture; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.capture (
    id text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    payment_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    created_by text,
    metadata jsonb
);


--
-- Name: cart_payment_collection; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cart_payment_collection (
    cart_id character varying(255) NOT NULL,
    payment_collection_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: commission_line; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.commission_line (
    id text NOT NULL,
    item_id text,
    commission_rate_id text,
    code text NOT NULL,
    rate real NOT NULL,
    amount numeric NOT NULL,
    description text,
    raw_amount jsonb NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    shipping_method_id text,
    CONSTRAINT commission_line_item_or_shipping_check CHECK ((num_nonnulls(item_id, shipping_method_id) = 1))
);


--
-- Name: commission_rate; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.commission_rate (
    id text NOT NULL,
    is_enabled boolean DEFAULT true NOT NULL,
    currency_code text,
    name text NOT NULL,
    code text NOT NULL,
    type text NOT NULL,
    value numeric NOT NULL,
    include_tax boolean DEFAULT false NOT NULL,
    raw_value jsonb NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    include_shipping boolean DEFAULT false NOT NULL,
    is_default boolean DEFAULT false NOT NULL,
    CONSTRAINT commission_rate_type_check CHECK ((type = ANY (ARRAY['fixed'::text, 'percentage'::text])))
);


--
-- Name: commission_rate_value; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.commission_rate_value (
    id text NOT NULL,
    currency_code text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    commission_rate_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: commission_rule; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.commission_rule (
    id text NOT NULL,
    reference text NOT NULL,
    reference_id text NOT NULL,
    commission_rate_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: image; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.image (
    id text NOT NULL,
    url text NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    rank integer DEFAULT 0 NOT NULL,
    product_id text NOT NULL
);


--
-- Name: member_invite; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.member_invite (
    id text NOT NULL,
    email text NOT NULL,
    token text NOT NULL,
    accepted boolean DEFAULT false NOT NULL,
    expires_at timestamp with time zone NOT NULL,
    role_id text NOT NULL,
    seller_id text NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: offer; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.offer (
    id text NOT NULL,
    seller_id text NOT NULL,
    variant_id text NOT NULL,
    shipping_profile_id text NOT NULL,
    sku text NOT NULL,
    ean text,
    upc text,
    created_by text NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    product_id text DEFAULT ''::text NOT NULL
);


--
-- Name: offer_inventory_item; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.offer_inventory_item (
    offer_id character varying(255) NOT NULL,
    inventory_item_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    required_quantity integer DEFAULT 1 NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: offer_offer_pricing_price; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.offer_offer_pricing_price (
    offer_id character varying(255) NOT NULL,
    price_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: onboarding; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.onboarding (
    id text NOT NULL,
    data jsonb,
    context jsonb,
    account_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public."order" (
    id text NOT NULL,
    region_id text,
    display_id integer,
    customer_id text,
    version integer DEFAULT 1 NOT NULL,
    sales_channel_id text,
    status public.order_status_enum DEFAULT 'pending'::public.order_status_enum NOT NULL,
    is_draft_order boolean DEFAULT false NOT NULL,
    email text,
    currency_code text NOT NULL,
    shipping_address_id text,
    billing_address_id text,
    no_notification boolean,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    canceled_at timestamp with time zone,
    custom_display_id text,
    locale text
);


--
-- Name: order_change; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_change (
    id text NOT NULL,
    order_id text NOT NULL,
    version integer NOT NULL,
    description text,
    status text DEFAULT 'pending'::text NOT NULL,
    internal_note text,
    created_by text,
    requested_by text,
    requested_at timestamp with time zone,
    confirmed_by text,
    confirmed_at timestamp with time zone,
    declined_by text,
    declined_reason text,
    metadata jsonb,
    declined_at timestamp with time zone,
    canceled_by text,
    canceled_at timestamp with time zone,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    change_type text,
    deleted_at timestamp with time zone,
    return_id text,
    claim_id text,
    exchange_id text,
    carry_over_promotions boolean,
    CONSTRAINT order_change_status_check CHECK ((status = ANY (ARRAY['confirmed'::text, 'declined'::text, 'requested'::text, 'pending'::text, 'canceled'::text])))
);


--
-- Name: order_change_action; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_change_action (
    id text NOT NULL,
    order_id text,
    version integer,
    ordering bigint NOT NULL,
    order_change_id text,
    reference text,
    reference_id text,
    action text NOT NULL,
    details jsonb,
    amount numeric,
    raw_amount jsonb,
    internal_note text,
    applied boolean DEFAULT false NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    return_id text,
    claim_id text,
    exchange_id text
);


--
-- Name: order_change_action_ordering_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.order_change_action_ordering_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: order_change_action_ordering_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.order_change_action_ordering_seq OWNED BY public.order_change_action.ordering;


--
-- Name: order_credit_line; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_credit_line (
    id text NOT NULL,
    order_id text NOT NULL,
    reference text,
    reference_id text,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    version integer DEFAULT 1 NOT NULL
);


--
-- Name: order_display_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.order_display_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: order_display_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.order_display_id_seq OWNED BY public."order".display_id;


--
-- Name: order_item; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_item (
    id text NOT NULL,
    order_id text NOT NULL,
    version integer NOT NULL,
    item_id text NOT NULL,
    quantity numeric NOT NULL,
    raw_quantity jsonb NOT NULL,
    fulfilled_quantity numeric NOT NULL,
    raw_fulfilled_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    shipped_quantity numeric NOT NULL,
    raw_shipped_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    return_requested_quantity numeric NOT NULL,
    raw_return_requested_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    return_received_quantity numeric NOT NULL,
    raw_return_received_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    return_dismissed_quantity numeric NOT NULL,
    raw_return_dismissed_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    written_off_quantity numeric NOT NULL,
    raw_written_off_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    delivered_quantity numeric DEFAULT 0 NOT NULL,
    raw_delivered_quantity jsonb DEFAULT '{"value": "0", "precision": 20}'::jsonb NOT NULL,
    unit_price numeric,
    raw_unit_price jsonb,
    compare_at_unit_price numeric,
    raw_compare_at_unit_price jsonb
);


--
-- Name: order_line_item; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_line_item (
    id text NOT NULL,
    totals_id text,
    title text NOT NULL,
    subtitle text,
    thumbnail text,
    variant_id text,
    product_id text,
    product_title text,
    product_description text,
    product_subtitle text,
    product_type text,
    product_collection text,
    product_handle text,
    variant_sku text,
    variant_barcode text,
    variant_title text,
    variant_option_values jsonb,
    requires_shipping boolean DEFAULT true NOT NULL,
    is_discountable boolean DEFAULT true NOT NULL,
    is_tax_inclusive boolean DEFAULT false NOT NULL,
    compare_at_unit_price numeric,
    raw_compare_at_unit_price jsonb,
    unit_price numeric NOT NULL,
    raw_unit_price jsonb NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    is_custom_price boolean DEFAULT false NOT NULL,
    product_type_id text,
    is_giftcard boolean DEFAULT false NOT NULL
);


--
-- Name: order_line_item_adjustment; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_line_item_adjustment (
    id text NOT NULL,
    description text,
    promotion_id text,
    code text,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    provider_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    item_id text NOT NULL,
    deleted_at timestamp with time zone,
    is_tax_inclusive boolean DEFAULT false NOT NULL,
    version integer DEFAULT 1 NOT NULL
);


--
-- Name: order_line_item_tax_line; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_line_item_tax_line (
    id text NOT NULL,
    description text,
    tax_rate_id text,
    code text NOT NULL,
    rate numeric NOT NULL,
    raw_rate jsonb NOT NULL,
    provider_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    item_id text NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order_promotion; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_promotion (
    order_id character varying(255) NOT NULL,
    promotion_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order_shipping; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_shipping (
    id text NOT NULL,
    order_id text NOT NULL,
    version integer NOT NULL,
    shipping_method_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    return_id text,
    claim_id text,
    exchange_id text
);


--
-- Name: order_shipping_method; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_shipping_method (
    id text NOT NULL,
    name text NOT NULL,
    description jsonb,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    is_tax_inclusive boolean DEFAULT false NOT NULL,
    shipping_option_id text,
    data jsonb,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    is_custom_amount boolean DEFAULT false NOT NULL
);


--
-- Name: order_shipping_method_adjustment; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_shipping_method_adjustment (
    id text NOT NULL,
    description text,
    promotion_id text,
    code text,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    provider_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    shipping_method_id text NOT NULL,
    deleted_at timestamp with time zone,
    version integer DEFAULT 1 NOT NULL
);


--
-- Name: order_shipping_method_tax_line; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_shipping_method_tax_line (
    id text NOT NULL,
    description text,
    tax_rate_id text,
    code text NOT NULL,
    rate numeric NOT NULL,
    raw_rate jsonb NOT NULL,
    provider_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    shipping_method_id text NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order_summary; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_summary (
    id text NOT NULL,
    order_id text NOT NULL,
    version integer DEFAULT 1 NOT NULL,
    totals jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order_transaction; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.order_transaction (
    id text NOT NULL,
    order_id text NOT NULL,
    version integer DEFAULT 1 NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    currency_code text NOT NULL,
    reference text,
    reference_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    return_id text,
    claim_id text,
    exchange_id text
);


--
-- Name: payment; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment (
    id text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    currency_code text NOT NULL,
    provider_id text NOT NULL,
    data jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    captured_at timestamp with time zone,
    canceled_at timestamp with time zone,
    payment_collection_id text NOT NULL,
    payment_session_id text NOT NULL,
    metadata jsonb
);


--
-- Name: payment_collection; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment_collection (
    id text NOT NULL,
    currency_code text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    authorized_amount numeric,
    raw_authorized_amount jsonb,
    captured_amount numeric,
    raw_captured_amount jsonb,
    refunded_amount numeric,
    raw_refunded_amount jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    completed_at timestamp with time zone,
    status text DEFAULT 'not_paid'::text NOT NULL,
    metadata jsonb,
    CONSTRAINT payment_collection_status_check CHECK ((status = ANY (ARRAY['not_paid'::text, 'awaiting'::text, 'authorized'::text, 'partially_authorized'::text, 'canceled'::text, 'failed'::text, 'partially_captured'::text, 'completed'::text])))
);


--
-- Name: payment_collection_payment_providers; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment_collection_payment_providers (
    payment_collection_id text NOT NULL,
    payment_provider_id text NOT NULL
);


--
-- Name: payment_details; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment_details (
    id text NOT NULL,
    holder_name text,
    bank_name text,
    iban text,
    bic text,
    routing_number text,
    account_number text,
    seller_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    country_code text DEFAULT ''::text
);


--
-- Name: payment_provider; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment_provider (
    id text NOT NULL,
    is_enabled boolean DEFAULT true NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: payment_session; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payment_session (
    id text NOT NULL,
    currency_code text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    provider_id text NOT NULL,
    data jsonb DEFAULT '{}'::jsonb NOT NULL,
    context jsonb,
    status text DEFAULT 'pending'::text NOT NULL,
    authorized_at timestamp with time zone,
    payment_collection_id text NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    CONSTRAINT payment_session_status_check CHECK ((status = ANY (ARRAY['authorized'::text, 'captured'::text, 'pending'::text, 'requires_more'::text, 'error'::text, 'canceled'::text, 'pending_authorization'::text])))
);


--
-- Name: payout; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payout (
    id text NOT NULL,
    currency_code text NOT NULL,
    amount numeric NOT NULL,
    data jsonb,
    account_id text NOT NULL,
    status text DEFAULT 'pending'::text NOT NULL,
    raw_amount jsonb NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    display_id integer NOT NULL,
    CONSTRAINT payout_status_check CHECK ((status = ANY (ARRAY['pending'::text, 'paid'::text, 'failed'::text, 'canceled'::text])))
);


--
-- Name: payout_account; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.payout_account (
    id text NOT NULL,
    status text DEFAULT 'pending'::text NOT NULL,
    data jsonb NOT NULL,
    context jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    CONSTRAINT payout_account_status_check CHECK ((status = ANY (ARRAY['pending'::text, 'active'::text, 'restricted'::text, 'rejected'::text])))
);


--
-- Name: payout_display_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.payout_display_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: payout_display_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.payout_display_id_seq OWNED BY public.payout.display_id;


--
-- Name: product; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product (
    id text NOT NULL,
    title text NOT NULL,
    handle text NOT NULL,
    subtitle text,
    description text,
    is_giftcard boolean DEFAULT false NOT NULL,
    status text DEFAULT 'draft'::text NOT NULL,
    thumbnail text,
    weight real,
    length real,
    height real,
    width real,
    origin_country text,
    hs_code text,
    mid_code text,
    material text,
    collection_id text,
    type_id text,
    discountable boolean DEFAULT true NOT NULL,
    external_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    metadata jsonb,
    CONSTRAINT product_status_check CHECK ((status = ANY (ARRAY['draft'::text, 'proposed'::text, 'published'::text, 'rejected'::text])))
);


--
-- Name: product_attribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_attribute (
    id text NOT NULL,
    handle text,
    name text NOT NULL,
    description text,
    type text NOT NULL,
    is_required boolean DEFAULT false NOT NULL,
    is_filterable boolean DEFAULT false NOT NULL,
    is_variant_axis boolean DEFAULT false NOT NULL,
    rank integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_by text,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    product_id text,
    product_option_id text
);


--
-- Name: product_attribute_value; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_attribute_value (
    id text NOT NULL,
    handle text,
    name text NOT NULL,
    rank integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    metadata jsonb,
    attribute_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    product_option_value_id text
);


--
-- Name: product_attribute_value_link; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_attribute_value_link (
    product_id character varying(255) NOT NULL,
    product_attribute_value_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: product_category; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_category (
    id text NOT NULL,
    name text NOT NULL,
    description text DEFAULT ''::text NOT NULL,
    handle text NOT NULL,
    mpath text NOT NULL,
    is_active boolean DEFAULT false NOT NULL,
    is_internal boolean DEFAULT false NOT NULL,
    rank integer DEFAULT 0 NOT NULL,
    parent_category_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    metadata jsonb,
    external_id text
);


--
-- Name: product_category_attribute; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_category_attribute (
    product_attribute_id character varying(255) NOT NULL,
    product_category_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: product_category_product; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_category_product (
    product_id text NOT NULL,
    product_category_id text NOT NULL
);


--
-- Name: product_option; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_option (
    id text NOT NULL,
    title text NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    is_exclusive boolean DEFAULT false NOT NULL
);


--
-- Name: product_option_value; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_option_value (
    id text NOT NULL,
    value text NOT NULL,
    option_id text,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    rank integer
);


--
-- Name: product_seller; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_seller (
    product_id character varying(255) NOT NULL,
    seller_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: product_variant; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.product_variant (
    id text NOT NULL,
    title text NOT NULL,
    sku text,
    barcode text,
    ean text,
    upc text,
    allow_backorder boolean DEFAULT false NOT NULL,
    manage_inventory boolean DEFAULT true NOT NULL,
    hs_code text,
    origin_country text,
    mid_code text,
    material text,
    weight real,
    length real,
    height real,
    width real,
    metadata jsonb,
    variant_rank integer DEFAULT 0,
    product_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    thumbnail text
);


--
-- Name: professional_details; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.professional_details (
    id text NOT NULL,
    corporate_name text,
    registration_number text,
    tax_id text,
    seller_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: refund; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.refund (
    id text NOT NULL,
    amount numeric NOT NULL,
    raw_amount jsonb NOT NULL,
    payment_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    created_by text,
    metadata jsonb,
    refund_reason_id text,
    note text
);


--
-- Name: review; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.review (
    id text NOT NULL,
    display_id integer NOT NULL,
    reference text NOT NULL,
    rating integer NOT NULL,
    customer_note text,
    seller_note text,
    status text DEFAULT 'pending'::text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    CONSTRAINT review_reference_check CHECK ((reference = ANY (ARRAY['product'::text, 'seller'::text]))),
    CONSTRAINT review_status_check CHECK ((status = ANY (ARRAY['pending'::text, 'published'::text, 'rejected'::text])))
);


--
-- Name: review_display_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.review_display_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: review_display_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.review_display_id_seq OWNED BY public.review.display_id;


--
-- Name: seller; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller (
    id text NOT NULL,
    name text NOT NULL,
    handle text NOT NULL,
    email text NOT NULL,
    description text,
    logo text,
    banner text,
    website_url text,
    external_id text,
    currency_code text NOT NULL,
    status text DEFAULT 'pending_approval'::text NOT NULL,
    status_reason text,
    is_premium boolean DEFAULT false NOT NULL,
    closed_from timestamp with time zone,
    closed_to timestamp with time zone,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    closure_note text,
    phone text,
    approved_at timestamp with time zone,
    rejected_at timestamp with time zone,
    CONSTRAINT seller_status_check CHECK ((status = ANY (ARRAY['open'::text, 'pending_approval'::text, 'suspended'::text, 'terminated'::text])))
);


--
-- Name: seller_address; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_address (
    id text NOT NULL,
    company text,
    first_name text,
    last_name text,
    address_1 text,
    address_2 text,
    city text,
    country_code text,
    province text,
    postal_code text,
    phone text,
    metadata jsonb,
    seller_id text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    name text
);


--
-- Name: seller_member; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_member (
    id text NOT NULL,
    seller_id text NOT NULL,
    member_id text NOT NULL,
    role_id text,
    is_owner boolean DEFAULT false NOT NULL,
    metadata jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: seller_seller_customer_customer; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_seller_customer_customer (
    seller_id character varying(255) NOT NULL,
    customer_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: seller_seller_fulfillment_fulfillment_set; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_seller_fulfillment_fulfillment_set (
    seller_id character varying(255) NOT NULL,
    fulfillment_set_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: seller_seller_fulfillment_service_zone; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_seller_fulfillment_service_zone (
    seller_id character varying(255) NOT NULL,
    service_zone_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: seller_seller_payout_payout_account; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_seller_payout_payout_account (
    seller_id character varying(255) NOT NULL,
    payout_account_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: seller_seller_review_review; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.seller_seller_review_review (
    seller_id character varying(255) NOT NULL,
    review_id character varying(255) NOT NULL,
    id character varying(255) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    deleted_at timestamp with time zone
);


--
-- Name: order display_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."order" ALTER COLUMN display_id SET DEFAULT nextval('public.order_display_id_seq'::regclass);


--
-- Name: order_change_action ordering; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_change_action ALTER COLUMN ordering SET DEFAULT nextval('public.order_change_action_ordering_seq'::regclass);


--
-- Name: payout display_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payout ALTER COLUMN display_id SET DEFAULT nextval('public.payout_display_id_seq'::regclass);


--
-- Name: review display_id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review ALTER COLUMN display_id SET DEFAULT nextval('public.review_display_id_seq'::regclass);


--
-- Name: capture capture_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.capture
    ADD CONSTRAINT capture_pkey PRIMARY KEY (id);


--
-- Name: cart_payment_collection cart_payment_collection_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cart_payment_collection
    ADD CONSTRAINT cart_payment_collection_pkey PRIMARY KEY (cart_id, payment_collection_id);


--
-- Name: commission_line commission_line_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_line
    ADD CONSTRAINT commission_line_pkey PRIMARY KEY (id);


--
-- Name: commission_rate commission_rate_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_rate
    ADD CONSTRAINT commission_rate_pkey PRIMARY KEY (id);


--
-- Name: commission_rate_value commission_rate_value_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_rate_value
    ADD CONSTRAINT commission_rate_value_pkey PRIMARY KEY (id);


--
-- Name: commission_rule commission_rule_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_rule
    ADD CONSTRAINT commission_rule_pkey PRIMARY KEY (id);


--
-- Name: image image_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.image
    ADD CONSTRAINT image_pkey PRIMARY KEY (id);


--
-- Name: member_invite member_invite_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.member_invite
    ADD CONSTRAINT member_invite_pkey PRIMARY KEY (id);


--
-- Name: offer_inventory_item offer_inventory_item_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.offer_inventory_item
    ADD CONSTRAINT offer_inventory_item_pkey PRIMARY KEY (offer_id, inventory_item_id);


--
-- Name: offer_offer_pricing_price offer_offer_pricing_price_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.offer_offer_pricing_price
    ADD CONSTRAINT offer_offer_pricing_price_pkey PRIMARY KEY (offer_id, price_id);


--
-- Name: offer offer_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.offer
    ADD CONSTRAINT offer_pkey PRIMARY KEY (id);


--
-- Name: onboarding onboarding_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.onboarding
    ADD CONSTRAINT onboarding_pkey PRIMARY KEY (id);


--
-- Name: order_change_action order_change_action_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_change_action
    ADD CONSTRAINT order_change_action_pkey PRIMARY KEY (id);


--
-- Name: order_change order_change_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_change
    ADD CONSTRAINT order_change_pkey PRIMARY KEY (id);


--
-- Name: order_credit_line order_credit_line_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_credit_line
    ADD CONSTRAINT order_credit_line_pkey PRIMARY KEY (id);


--
-- Name: order_item order_item_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_item
    ADD CONSTRAINT order_item_pkey PRIMARY KEY (id);


--
-- Name: order_line_item_adjustment order_line_item_adjustment_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item_adjustment
    ADD CONSTRAINT order_line_item_adjustment_pkey PRIMARY KEY (id);


--
-- Name: order_line_item order_line_item_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item
    ADD CONSTRAINT order_line_item_pkey PRIMARY KEY (id);


--
-- Name: order_line_item_tax_line order_line_item_tax_line_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item_tax_line
    ADD CONSTRAINT order_line_item_tax_line_pkey PRIMARY KEY (id);


--
-- Name: order order_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."order"
    ADD CONSTRAINT order_pkey PRIMARY KEY (id);


--
-- Name: order_promotion order_promotion_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_promotion
    ADD CONSTRAINT order_promotion_pkey PRIMARY KEY (order_id, promotion_id);


--
-- Name: order_shipping_method_adjustment order_shipping_method_adjustment_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping_method_adjustment
    ADD CONSTRAINT order_shipping_method_adjustment_pkey PRIMARY KEY (id);


--
-- Name: order_shipping_method order_shipping_method_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping_method
    ADD CONSTRAINT order_shipping_method_pkey PRIMARY KEY (id);


--
-- Name: order_shipping_method_tax_line order_shipping_method_tax_line_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping_method_tax_line
    ADD CONSTRAINT order_shipping_method_tax_line_pkey PRIMARY KEY (id);


--
-- Name: order_shipping order_shipping_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping
    ADD CONSTRAINT order_shipping_pkey PRIMARY KEY (id);


--
-- Name: order_summary order_summary_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_summary
    ADD CONSTRAINT order_summary_pkey PRIMARY KEY (id);


--
-- Name: order_transaction order_transaction_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_transaction
    ADD CONSTRAINT order_transaction_pkey PRIMARY KEY (id);


--
-- Name: payment_collection_payment_providers payment_collection_payment_providers_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_collection_payment_providers
    ADD CONSTRAINT payment_collection_payment_providers_pkey PRIMARY KEY (payment_collection_id, payment_provider_id);


--
-- Name: payment_collection payment_collection_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_collection
    ADD CONSTRAINT payment_collection_pkey PRIMARY KEY (id);


--
-- Name: payment_details payment_details_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_details
    ADD CONSTRAINT payment_details_pkey PRIMARY KEY (id);


--
-- Name: payment payment_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment
    ADD CONSTRAINT payment_pkey PRIMARY KEY (id);


--
-- Name: payment_provider payment_provider_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_provider
    ADD CONSTRAINT payment_provider_pkey PRIMARY KEY (id);


--
-- Name: payment_session payment_session_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_session
    ADD CONSTRAINT payment_session_pkey PRIMARY KEY (id);


--
-- Name: payout_account payout_account_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payout_account
    ADD CONSTRAINT payout_account_pkey PRIMARY KEY (id);


--
-- Name: payout payout_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payout
    ADD CONSTRAINT payout_pkey PRIMARY KEY (id);


--
-- Name: product_attribute product_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_attribute
    ADD CONSTRAINT product_attribute_pkey PRIMARY KEY (id);


--
-- Name: product_attribute_value_link product_attribute_value_link_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_attribute_value_link
    ADD CONSTRAINT product_attribute_value_link_pkey PRIMARY KEY (product_id, product_attribute_value_id);


--
-- Name: product_attribute_value product_attribute_value_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_attribute_value
    ADD CONSTRAINT product_attribute_value_pkey PRIMARY KEY (id);


--
-- Name: product_category_attribute product_category_attribute_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category_attribute
    ADD CONSTRAINT product_category_attribute_pkey PRIMARY KEY (product_attribute_id, product_category_id);


--
-- Name: product_category product_category_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category
    ADD CONSTRAINT product_category_pkey PRIMARY KEY (id);


--
-- Name: product_category_product product_category_product_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category_product
    ADD CONSTRAINT product_category_product_pkey PRIMARY KEY (product_id, product_category_id);


--
-- Name: product_option product_option_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_option
    ADD CONSTRAINT product_option_pkey PRIMARY KEY (id);


--
-- Name: product_option_value product_option_value_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_option_value
    ADD CONSTRAINT product_option_value_pkey PRIMARY KEY (id);


--
-- Name: product product_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_pkey PRIMARY KEY (id);


--
-- Name: product_seller product_seller_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_seller
    ADD CONSTRAINT product_seller_pkey PRIMARY KEY (product_id, seller_id);


--
-- Name: product_variant product_variant_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_variant
    ADD CONSTRAINT product_variant_pkey PRIMARY KEY (id);


--
-- Name: professional_details professional_details_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.professional_details
    ADD CONSTRAINT professional_details_pkey PRIMARY KEY (id);


--
-- Name: refund refund_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.refund
    ADD CONSTRAINT refund_pkey PRIMARY KEY (id);


--
-- Name: review review_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.review
    ADD CONSTRAINT review_pkey PRIMARY KEY (id);


--
-- Name: seller_address seller_address_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_address
    ADD CONSTRAINT seller_address_pkey PRIMARY KEY (id);


--
-- Name: seller_member seller_member_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_member
    ADD CONSTRAINT seller_member_pkey PRIMARY KEY (id);


--
-- Name: seller seller_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller
    ADD CONSTRAINT seller_pkey PRIMARY KEY (id);


--
-- Name: seller_seller_customer_customer seller_seller_customer_customer_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_seller_customer_customer
    ADD CONSTRAINT seller_seller_customer_customer_pkey PRIMARY KEY (seller_id, customer_id);


--
-- Name: seller_seller_fulfillment_fulfillment_set seller_seller_fulfillment_fulfillment_set_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_seller_fulfillment_fulfillment_set
    ADD CONSTRAINT seller_seller_fulfillment_fulfillment_set_pkey PRIMARY KEY (seller_id, fulfillment_set_id);


--
-- Name: seller_seller_fulfillment_service_zone seller_seller_fulfillment_service_zone_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_seller_fulfillment_service_zone
    ADD CONSTRAINT seller_seller_fulfillment_service_zone_pkey PRIMARY KEY (seller_id, service_zone_id);


--
-- Name: seller_seller_payout_payout_account seller_seller_payout_payout_account_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_seller_payout_payout_account
    ADD CONSTRAINT seller_seller_payout_payout_account_pkey PRIMARY KEY (seller_id, payout_account_id);


--
-- Name: seller_seller_review_review seller_seller_review_review_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_seller_review_review
    ADD CONSTRAINT seller_seller_review_review_pkey PRIMARY KEY (seller_id, review_id);


--
-- Name: IDX_capture_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_capture_deleted_at" ON public.capture USING btree (deleted_at);


--
-- Name: IDX_capture_payment_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_capture_payment_id" ON public.capture USING btree (payment_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_cart_id_-4a39f6c9; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_cart_id_-4a39f6c9" ON public.cart_payment_collection USING btree (cart_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_category_handle_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_category_handle_unique" ON public.product_category USING btree (handle) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_line_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_line_deleted_at" ON public.commission_line USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_line_item_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_line_item_id" ON public.commission_line USING btree (item_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_line_shipping_method_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_line_shipping_method_id" ON public.commission_line USING btree (shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rate_code_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_commission_rate_code_unique" ON public.commission_rate USING btree (code) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rate_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rate_deleted_at" ON public.commission_rate USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rate_value_commission_rate_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rate_value_commission_rate_id" ON public.commission_rate_value USING btree (commission_rate_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rate_value_currency_code; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rate_value_currency_code" ON public.commission_rate_value USING btree (currency_code) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rate_value_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rate_value_deleted_at" ON public.commission_rate_value USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rule_commission_rate_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rule_commission_rate_id" ON public.commission_rule USING btree (commission_rate_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_commission_rule_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_commission_rule_deleted_at" ON public.commission_rule USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_customer_id_-71525e4c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_customer_id_-71525e4c" ON public.seller_seller_customer_customer USING btree (customer_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_deleted_at_-13980f8aa; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-13980f8aa" ON public.product_category_attribute USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-194faa82; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-194faa82" ON public.seller_seller_fulfillment_service_zone USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-1c99f363b; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-1c99f363b" ON public.offer_offer_pricing_price USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-4a39f6c9; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-4a39f6c9" ON public.cart_payment_collection USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-71518339; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-71518339" ON public.order_promotion USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-71525e4c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-71525e4c" ON public.seller_seller_customer_customer USING btree (deleted_at);


--
-- Name: IDX_deleted_at_-bd8ccaa1; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_-bd8ccaa1" ON public.seller_seller_fulfillment_fulfillment_set USING btree (deleted_at);


--
-- Name: IDX_deleted_at_139d4bc2c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_139d4bc2c" ON public.product_seller USING btree (deleted_at);


--
-- Name: IDX_deleted_at_169ccbc72; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_169ccbc72" ON public.offer_inventory_item USING btree (deleted_at);


--
-- Name: IDX_deleted_at_4f72ad74; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_4f72ad74" ON public.seller_seller_review_review USING btree (deleted_at);


--
-- Name: IDX_deleted_at_7387180; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_7387180" ON public.seller_seller_payout_payout_account USING btree (deleted_at);


--
-- Name: IDX_deleted_at_e7759b62; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_deleted_at_e7759b62" ON public.product_attribute_value_link USING btree (deleted_at);


--
-- Name: IDX_fulfillment_set_id_-bd8ccaa1; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_fulfillment_set_id_-bd8ccaa1" ON public.seller_seller_fulfillment_fulfillment_set USING btree (fulfillment_set_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_id_-13980f8aa; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-13980f8aa" ON public.product_category_attribute USING btree (id);


--
-- Name: IDX_id_-194faa82; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-194faa82" ON public.seller_seller_fulfillment_service_zone USING btree (id);


--
-- Name: IDX_id_-1c99f363b; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-1c99f363b" ON public.offer_offer_pricing_price USING btree (id);


--
-- Name: IDX_id_-4a39f6c9; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-4a39f6c9" ON public.cart_payment_collection USING btree (id);


--
-- Name: IDX_id_-71518339; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-71518339" ON public.order_promotion USING btree (id);


--
-- Name: IDX_id_-71525e4c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-71525e4c" ON public.seller_seller_customer_customer USING btree (id);


--
-- Name: IDX_id_-bd8ccaa1; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_-bd8ccaa1" ON public.seller_seller_fulfillment_fulfillment_set USING btree (id);


--
-- Name: IDX_id_139d4bc2c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_139d4bc2c" ON public.product_seller USING btree (id);


--
-- Name: IDX_id_169ccbc72; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_169ccbc72" ON public.offer_inventory_item USING btree (id);


--
-- Name: IDX_id_4f72ad74; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_4f72ad74" ON public.seller_seller_review_review USING btree (id);


--
-- Name: IDX_id_7387180; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_7387180" ON public.seller_seller_payout_payout_account USING btree (id);


--
-- Name: IDX_id_e7759b62; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_id_e7759b62" ON public.product_attribute_value_link USING btree (id);


--
-- Name: IDX_image_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_image_deleted_at" ON public.image USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_image_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_image_product_id" ON public.image USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_inventory_item_id_169ccbc72; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_inventory_item_id_169ccbc72" ON public.offer_inventory_item USING btree (inventory_item_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_line_item_product_type_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_line_item_product_type_id" ON public.order_line_item USING btree (product_type_id) WHERE ((deleted_at IS NULL) AND (product_type_id IS NOT NULL));


--
-- Name: IDX_member_invite_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_member_invite_deleted_at" ON public.member_invite USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_member_invite_email_seller_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_member_invite_email_seller_id_unique" ON public.member_invite USING btree (email, seller_id) WHERE ((deleted_at IS NULL) AND (accepted = false));


--
-- Name: IDX_member_invite_seller_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_member_invite_seller_id" ON public.member_invite USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_member_invite_token; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_member_invite_token" ON public.member_invite USING btree (token) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_deleted_at" ON public.offer USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_ean; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_ean" ON public.offer USING btree (ean) WHERE ((deleted_at IS NULL) AND (ean IS NOT NULL));


--
-- Name: IDX_offer_id_-1c99f363b; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_id_-1c99f363b" ON public.offer_offer_pricing_price USING btree (offer_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_id_169ccbc72; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_id_169ccbc72" ON public.offer_inventory_item USING btree (offer_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_product_id" ON public.offer USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_seller_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_seller_id" ON public.offer USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_seller_sku_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_offer_seller_sku_unique" ON public.offer USING btree (seller_id, sku) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_shipping_profile_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_shipping_profile_id" ON public.offer USING btree (shipping_profile_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_offer_upc; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_upc" ON public.offer USING btree (upc) WHERE ((deleted_at IS NULL) AND (upc IS NOT NULL));


--
-- Name: IDX_offer_variant_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_offer_variant_id" ON public.offer USING btree (variant_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_onboarding_account_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_onboarding_account_id_unique" ON public.onboarding USING btree (account_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_onboarding_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_onboarding_deleted_at" ON public.onboarding USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_option_value_option_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_option_value_option_id_unique" ON public.product_option_value USING btree (option_id, value) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_billing_address_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_billing_address_id" ON public."order" USING btree (billing_address_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_action_claim_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_claim_id" ON public.order_change_action USING btree (claim_id) WHERE ((claim_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_action_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_deleted_at" ON public.order_change_action USING btree (deleted_at);


--
-- Name: IDX_order_change_action_exchange_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_exchange_id" ON public.order_change_action USING btree (exchange_id) WHERE ((exchange_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_action_order_change_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_order_change_id" ON public.order_change_action USING btree (order_change_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_action_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_order_id" ON public.order_change_action USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_action_ordering; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_ordering" ON public.order_change_action USING btree (ordering) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_action_return_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_action_return_id" ON public.order_change_action USING btree (return_id) WHERE ((return_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_change_type; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_change_type" ON public.order_change USING btree (change_type);


--
-- Name: IDX_order_change_claim_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_claim_id" ON public.order_change USING btree (claim_id) WHERE ((claim_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_deleted_at" ON public.order_change USING btree (deleted_at);


--
-- Name: IDX_order_change_exchange_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_exchange_id" ON public.order_change USING btree (exchange_id) WHERE ((exchange_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_order_id" ON public.order_change USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_order_id_version" ON public.order_change USING btree (order_id, version);


--
-- Name: IDX_order_change_return_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_return_id" ON public.order_change USING btree (return_id) WHERE ((return_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_change_status; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_status" ON public.order_change USING btree (status) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_change_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_change_version" ON public.order_change USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_credit_line_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_credit_line_deleted_at" ON public.order_credit_line USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_order_credit_line_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_credit_line_order_id" ON public.order_credit_line USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_credit_line_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_credit_line_order_id_version" ON public.order_credit_line USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_currency_code; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_currency_code" ON public."order" USING btree (currency_code) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_custom_display_id; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_order_custom_display_id" ON public."order" USING btree (custom_display_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_customer_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_customer_id" ON public."order" USING btree (customer_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_deleted_at" ON public."order" USING btree (deleted_at);


--
-- Name: IDX_order_display_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_display_id" ON public."order" USING btree (display_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_id_-71518339; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_id_-71518339" ON public.order_promotion USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_is_draft_order; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_is_draft_order" ON public."order" USING btree (is_draft_order) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_item_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_item_deleted_at" ON public.order_item USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_order_item_item_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_item_item_id" ON public.order_item USING btree (item_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_item_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_item_order_id" ON public.order_item USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_item_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_item_order_id_version" ON public.order_item USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_line_item_adjustment_item_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_line_item_adjustment_item_id" ON public.order_line_item_adjustment USING btree (item_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_line_item_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_line_item_product_id" ON public.order_line_item USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_line_item_tax_line_item_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_line_item_tax_line_item_id" ON public.order_line_item_tax_line USING btree (item_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_line_item_variant_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_line_item_variant_id" ON public.order_line_item USING btree (variant_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_region_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_region_id" ON public."order" USING btree (region_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_sales_channel_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_sales_channel_id" ON public."order" USING btree (sales_channel_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_address_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_address_id" ON public."order" USING btree (shipping_address_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_claim_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_claim_id" ON public.order_shipping USING btree (claim_id) WHERE ((claim_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_shipping_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_deleted_at" ON public.order_shipping USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_order_shipping_exchange_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_exchange_id" ON public.order_shipping USING btree (exchange_id) WHERE ((exchange_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_shipping_item_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_item_id" ON public.order_shipping USING btree (shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_method_adjustment_shipping_method_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_method_adjustment_shipping_method_id" ON public.order_shipping_method_adjustment USING btree (shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_method_adjustment_version_shipping_method; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_order_shipping_method_adjustment_version_shipping_method" ON public.order_shipping_method_adjustment USING btree (version, shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_method_shipping_option_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_method_shipping_option_id" ON public.order_shipping_method USING btree (shipping_option_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_method_tax_line_shipping_method_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_method_tax_line_shipping_method_id" ON public.order_shipping_method_tax_line USING btree (shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_order_id" ON public.order_shipping USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_order_id_version" ON public.order_shipping USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_shipping_return_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_return_id" ON public.order_shipping USING btree (return_id) WHERE ((return_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_shipping_shipping_method_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_shipping_shipping_method_id" ON public.order_shipping USING btree (shipping_method_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_summary_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_summary_deleted_at" ON public.order_summary USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_order_summary_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_summary_order_id_version" ON public.order_summary USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_transaction_claim_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_claim_id" ON public.order_transaction USING btree (claim_id) WHERE ((claim_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_transaction_currency_code; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_currency_code" ON public.order_transaction USING btree (currency_code) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_transaction_exchange_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_exchange_id" ON public.order_transaction USING btree (exchange_id) WHERE ((exchange_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_order_transaction_order_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_order_id" ON public.order_transaction USING btree (order_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_transaction_order_id_version; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_order_id_version" ON public.order_transaction USING btree (order_id, version) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_transaction_reference_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_reference_id" ON public.order_transaction USING btree (reference_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_order_transaction_return_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_order_transaction_return_id" ON public.order_transaction USING btree (return_id) WHERE ((return_id IS NOT NULL) AND (deleted_at IS NULL));


--
-- Name: IDX_payment_collection_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_collection_deleted_at" ON public.payment_collection USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_payment_collection_id_-4a39f6c9; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_collection_id_-4a39f6c9" ON public.cart_payment_collection USING btree (payment_collection_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_deleted_at" ON public.payment USING btree (deleted_at) WHERE (deleted_at IS NOT NULL);


--
-- Name: IDX_payment_details_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_details_deleted_at" ON public.payment_details USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_details_seller_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_payment_details_seller_id_unique" ON public.payment_details USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_payment_collection_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_payment_collection_id" ON public.payment USING btree (payment_collection_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_payment_session_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_payment_session_id" ON public.payment USING btree (payment_session_id);


--
-- Name: IDX_payment_payment_session_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_payment_payment_session_id_unique" ON public.payment USING btree (payment_session_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_provider_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_provider_deleted_at" ON public.payment_provider USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_provider_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_provider_id" ON public.payment USING btree (provider_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payment_session_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_session_deleted_at" ON public.payment_session USING btree (deleted_at);


--
-- Name: IDX_payment_session_payment_collection_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payment_session_payment_collection_id" ON public.payment_session USING btree (payment_collection_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payout_account_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payout_account_deleted_at" ON public.payout_account USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payout_account_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payout_account_id" ON public.payout USING btree (account_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payout_account_id_7387180; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payout_account_id_7387180" ON public.seller_seller_payout_payout_account USING btree (payout_account_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_payout_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_payout_deleted_at" ON public.payout USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_price_id_-1c99f363b; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_price_id_-1c99f363b" ON public.offer_offer_pricing_price USING btree (price_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_attribute_handle_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_attribute_handle_unique" ON public.product_attribute USING btree (handle) WHERE ((deleted_at IS NULL) AND (handle IS NOT NULL));


--
-- Name: IDX_product_attribute_id_-13980f8aa; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_attribute_id_-13980f8aa" ON public.product_category_attribute USING btree (product_attribute_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_attribute_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_attribute_product_id" ON public.product_attribute USING btree (product_id) WHERE ((deleted_at IS NULL) AND (product_id IS NOT NULL));


--
-- Name: IDX_product_attribute_type; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_attribute_type" ON public.product_attribute USING btree (type) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_attribute_value_handle_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_attribute_value_handle_unique" ON public.product_attribute_value USING btree (attribute_id, handle) WHERE ((deleted_at IS NULL) AND (handle IS NOT NULL));


--
-- Name: IDX_product_attribute_value_id_e7759b62; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_attribute_value_id_e7759b62" ON public.product_attribute_value_link USING btree (product_attribute_value_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_category_id_-13980f8aa; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_category_id_-13980f8aa" ON public.product_category_attribute USING btree (product_category_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_category_parent_category_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_category_parent_category_id" ON public.product_category USING btree (parent_category_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_category_path; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_category_path" ON public.product_category USING btree (mpath) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_collection_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_collection_id" ON public.product USING btree (collection_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_deleted_at" ON public.product USING btree (deleted_at);


--
-- Name: IDX_product_handle_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_handle_unique" ON public.product USING btree (handle) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_id_139d4bc2c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_id_139d4bc2c" ON public.product_seller USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_id_e7759b62; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_id_e7759b62" ON public.product_attribute_value_link USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_image_rank; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_image_rank" ON public.image USING btree (rank) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_image_rank_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_image_rank_product_id" ON public.image USING btree (rank, product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_image_url; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_image_url" ON public.image USING btree (url) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_image_url_rank_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_image_url_rank_product_id" ON public.image USING btree (url, rank, product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_option_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_option_deleted_at" ON public.product_option USING btree (deleted_at);


--
-- Name: IDX_product_option_value_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_option_value_deleted_at" ON public.product_option_value USING btree (deleted_at);


--
-- Name: IDX_product_option_value_option_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_option_value_option_id" ON public.product_option_value USING btree (option_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_status; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_status" ON public.product USING btree (status) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_type_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_type_id" ON public.product USING btree (type_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_barcode_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_variant_barcode_unique" ON public.product_variant USING btree (barcode) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_variant_deleted_at" ON public.product_variant USING btree (deleted_at);


--
-- Name: IDX_product_variant_ean_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_variant_ean_unique" ON public.product_variant USING btree (ean) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_id_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_variant_id_product_id" ON public.product_variant USING btree (id, product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_product_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_product_variant_product_id" ON public.product_variant USING btree (product_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_sku_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_variant_sku_unique" ON public.product_variant USING btree (sku) WHERE (deleted_at IS NULL);


--
-- Name: IDX_product_variant_upc_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_product_variant_upc_unique" ON public.product_variant USING btree (upc) WHERE (deleted_at IS NULL);


--
-- Name: IDX_professional_details_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_professional_details_deleted_at" ON public.professional_details USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_professional_details_seller_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_professional_details_seller_id_unique" ON public.professional_details USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_promotion_id_-71518339; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_promotion_id_-71518339" ON public.order_promotion USING btree (promotion_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_refund_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_refund_deleted_at" ON public.refund USING btree (deleted_at);


--
-- Name: IDX_refund_payment_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_refund_payment_id" ON public.refund USING btree (payment_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_refund_refund_reason_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_refund_refund_reason_id" ON public.refund USING btree (refund_reason_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_review_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_review_deleted_at" ON public.review USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_review_id_4f72ad74; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_review_id_4f72ad74" ON public.seller_seller_review_review USING btree (review_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_active_closure; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_active_closure" ON public.seller USING btree (status, closed_from, closed_to) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_address_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_address_deleted_at" ON public.seller_address USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_address_seller_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_address_seller_id_unique" ON public.seller_address USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_deleted_at" ON public.seller USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_email_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_email_unique" ON public.seller USING btree (email) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_external_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_external_id_unique" ON public.seller USING btree (external_id) WHERE ((deleted_at IS NULL) AND (external_id IS NOT NULL));


--
-- Name: IDX_seller_handle_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_handle_unique" ON public.seller USING btree (handle) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_-194faa82; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_-194faa82" ON public.seller_seller_fulfillment_service_zone USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_-71525e4c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_-71525e4c" ON public.seller_seller_customer_customer USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_-bd8ccaa1; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_-bd8ccaa1" ON public.seller_seller_fulfillment_fulfillment_set USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_139d4bc2c; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_139d4bc2c" ON public.product_seller USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_4f72ad74; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_4f72ad74" ON public.seller_seller_review_review USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_id_7387180; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_id_7387180" ON public.seller_seller_payout_payout_account USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_member_deleted_at; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_member_deleted_at" ON public.seller_member USING btree (deleted_at) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_member_member_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_member_member_id" ON public.seller_member USING btree (member_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_member_seller_id; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_seller_member_seller_id" ON public.seller_member USING btree (seller_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_member_seller_id_member_id_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_member_seller_id_member_id_unique" ON public.seller_member USING btree (seller_id, member_id) WHERE (deleted_at IS NULL);


--
-- Name: IDX_seller_name_unique; Type: INDEX; Schema: public; Owner: -
--

CREATE UNIQUE INDEX "IDX_seller_name_unique" ON public.seller USING btree (name) WHERE (deleted_at IS NULL);


--
-- Name: IDX_service_zone_id_-194faa82; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX "IDX_service_zone_id_-194faa82" ON public.seller_seller_fulfillment_service_zone USING btree (service_zone_id) WHERE (deleted_at IS NULL);


--
-- Name: capture capture_payment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.capture
    ADD CONSTRAINT capture_payment_id_foreign FOREIGN KEY (payment_id) REFERENCES public.payment(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: commission_rate_value commission_rate_value_commission_rate_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_rate_value
    ADD CONSTRAINT commission_rate_value_commission_rate_id_foreign FOREIGN KEY (commission_rate_id) REFERENCES public.commission_rate(id) ON UPDATE CASCADE;


--
-- Name: commission_rule commission_rule_commission_rate_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.commission_rule
    ADD CONSTRAINT commission_rule_commission_rate_id_foreign FOREIGN KEY (commission_rate_id) REFERENCES public.commission_rate(id) ON UPDATE CASCADE;


--
-- Name: image image_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.image
    ADD CONSTRAINT image_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.product(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: member_invite member_invite_seller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.member_invite
    ADD CONSTRAINT member_invite_seller_id_foreign FOREIGN KEY (seller_id) REFERENCES public.seller(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: onboarding onboarding_account_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.onboarding
    ADD CONSTRAINT onboarding_account_id_foreign FOREIGN KEY (account_id) REFERENCES public.payout_account(id) ON UPDATE CASCADE;


--
-- Name: order order_billing_address_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."order"
    ADD CONSTRAINT order_billing_address_id_foreign FOREIGN KEY (billing_address_id) REFERENCES public.order_address(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: order_change_action order_change_action_order_change_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_change_action
    ADD CONSTRAINT order_change_action_order_change_id_foreign FOREIGN KEY (order_change_id) REFERENCES public.order_change(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_change order_change_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_change
    ADD CONSTRAINT order_change_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_credit_line order_credit_line_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_credit_line
    ADD CONSTRAINT order_credit_line_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_item order_item_item_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_item
    ADD CONSTRAINT order_item_item_id_foreign FOREIGN KEY (item_id) REFERENCES public.order_line_item(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_item order_item_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_item
    ADD CONSTRAINT order_item_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_line_item_adjustment order_line_item_adjustment_item_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item_adjustment
    ADD CONSTRAINT order_line_item_adjustment_item_id_foreign FOREIGN KEY (item_id) REFERENCES public.order_line_item(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_line_item_tax_line order_line_item_tax_line_item_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item_tax_line
    ADD CONSTRAINT order_line_item_tax_line_item_id_foreign FOREIGN KEY (item_id) REFERENCES public.order_line_item(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_line_item order_line_item_totals_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_line_item
    ADD CONSTRAINT order_line_item_totals_id_foreign FOREIGN KEY (totals_id) REFERENCES public.order_item(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order order_shipping_address_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public."order"
    ADD CONSTRAINT order_shipping_address_id_foreign FOREIGN KEY (shipping_address_id) REFERENCES public.order_address(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: order_shipping_method_adjustment order_shipping_method_adjustment_shipping_method_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping_method_adjustment
    ADD CONSTRAINT order_shipping_method_adjustment_shipping_method_id_foreign FOREIGN KEY (shipping_method_id) REFERENCES public.order_shipping_method(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_shipping_method_tax_line order_shipping_method_tax_line_shipping_method_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping_method_tax_line
    ADD CONSTRAINT order_shipping_method_tax_line_shipping_method_id_foreign FOREIGN KEY (shipping_method_id) REFERENCES public.order_shipping_method(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_shipping order_shipping_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_shipping
    ADD CONSTRAINT order_shipping_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_summary order_summary_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_summary
    ADD CONSTRAINT order_summary_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: order_transaction order_transaction_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.order_transaction
    ADD CONSTRAINT order_transaction_order_id_foreign FOREIGN KEY (order_id) REFERENCES public."order"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payment_collection_payment_providers payment_collection_payment_providers_payment_col_aa276_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_collection_payment_providers
    ADD CONSTRAINT payment_collection_payment_providers_payment_col_aa276_foreign FOREIGN KEY (payment_collection_id) REFERENCES public.payment_collection(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payment_collection_payment_providers payment_collection_payment_providers_payment_pro_2d555_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_collection_payment_providers
    ADD CONSTRAINT payment_collection_payment_providers_payment_pro_2d555_foreign FOREIGN KEY (payment_provider_id) REFERENCES public.payment_provider(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payment_details payment_details_seller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_details
    ADD CONSTRAINT payment_details_seller_id_foreign FOREIGN KEY (seller_id) REFERENCES public.seller(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payment payment_payment_collection_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment
    ADD CONSTRAINT payment_payment_collection_id_foreign FOREIGN KEY (payment_collection_id) REFERENCES public.payment_collection(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payment_session payment_session_payment_collection_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payment_session
    ADD CONSTRAINT payment_session_payment_collection_id_foreign FOREIGN KEY (payment_collection_id) REFERENCES public.payment_collection(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: payout payout_account_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.payout
    ADD CONSTRAINT payout_account_id_foreign FOREIGN KEY (account_id) REFERENCES public.payout_account(id) ON UPDATE CASCADE;


--
-- Name: product_attribute_value product_attribute_value_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_attribute_value
    ADD CONSTRAINT product_attribute_value_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.product_attribute(id) ON DELETE CASCADE;


--
-- Name: product_category product_category_parent_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category
    ADD CONSTRAINT product_category_parent_category_id_foreign FOREIGN KEY (parent_category_id) REFERENCES public.product_category(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: product_category_product product_category_product_product_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category_product
    ADD CONSTRAINT product_category_product_product_category_id_foreign FOREIGN KEY (product_category_id) REFERENCES public.product_category(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: product_category_product product_category_product_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_category_product
    ADD CONSTRAINT product_category_product_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.product(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: product product_collection_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_collection_id_foreign FOREIGN KEY (collection_id) REFERENCES public.product_collection(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: product_option_value product_option_value_option_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_option_value
    ADD CONSTRAINT product_option_value_option_id_foreign FOREIGN KEY (option_id) REFERENCES public.product_option(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: product product_type_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_type_id_foreign FOREIGN KEY (type_id) REFERENCES public.product_type(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: product_variant product_variant_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.product_variant
    ADD CONSTRAINT product_variant_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.product(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: professional_details professional_details_seller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.professional_details
    ADD CONSTRAINT professional_details_seller_id_foreign FOREIGN KEY (seller_id) REFERENCES public.seller(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: refund refund_payment_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.refund
    ADD CONSTRAINT refund_payment_id_foreign FOREIGN KEY (payment_id) REFERENCES public.payment(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: seller_address seller_address_seller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.seller_address
    ADD CONSTRAINT seller_address_seller_id_foreign FOREIGN KEY (seller_id) REFERENCES public.seller(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict 43m5dgRUeg4AgzspfaEjou62Yf1RZ4la0nvhBC1yD8TE2i9z3XgkVr7QnT4iEwe

