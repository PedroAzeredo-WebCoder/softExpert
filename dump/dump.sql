PGDMP         .                {         
   softexpert    15.2    15.2 ,    ,           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            -           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            .           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            /           1262    16396 
   softexpert    DATABASE     �   CREATE DATABASE softexpert WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE softexpert;
                postgres    false            �            1259    16441    adm_menu    TABLE     �   CREATE TABLE public.adm_menu (
    id integer NOT NULL,
    adm_menu_id integer,
    icone character varying(50),
    nome character varying(50) NOT NULL,
    link text,
    status boolean NOT NULL
);
    DROP TABLE public.adm_menu;
       public         heap    postgres    false            �            1259    16440    adm_menu_id_seq    SEQUENCE     �   CREATE SEQUENCE public.adm_menu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.adm_menu_id_seq;
       public          postgres    false    215            0           0    0    adm_menu_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.adm_menu_id_seq OWNED BY public.adm_menu.id;
          public          postgres    false    214            �            1259    16450    cad_compras    TABLE     �   CREATE TABLE public.cad_compras (
    id integer NOT NULL,
    cad_produto_id integer NOT NULL,
    cad_usuario_id integer NOT NULL,
    quantidade integer NOT NULL,
    dt_compra date NOT NULL
);
    DROP TABLE public.cad_compras;
       public         heap    postgres    false            �            1259    16449    cad_compras_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cad_compras_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.cad_compras_id_seq;
       public          postgres    false    217            1           0    0    cad_compras_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.cad_compras_id_seq OWNED BY public.cad_compras.id;
          public          postgres    false    216            �            1259    16457    cad_produtos    TABLE     �  CREATE TABLE public.cad_produtos (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    descricao text,
    preco numeric(10,2) NOT NULL,
    quantidade integer NOT NULL,
    imagem text,
    dt_create timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    dt_update timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    status boolean NOT NULL,
    cad_tipo_produto_id integer NOT NULL
);
     DROP TABLE public.cad_produtos;
       public         heap    postgres    false            �            1259    16456    cad_produtos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cad_produtos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.cad_produtos_id_seq;
       public          postgres    false    219            2           0    0    cad_produtos_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.cad_produtos_id_seq OWNED BY public.cad_produtos.id;
          public          postgres    false    218            �            1259    16468    cad_tipo_produto    TABLE     �   CREATE TABLE public.cad_tipo_produto (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    descricao character varying(255),
    percentual_imposto double precision NOT NULL,
    status boolean NOT NULL
);
 $   DROP TABLE public.cad_tipo_produto;
       public         heap    postgres    false            �            1259    16467    cad_tipo_produto_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cad_tipo_produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.cad_tipo_produto_id_seq;
       public          postgres    false    221            3           0    0    cad_tipo_produto_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.cad_tipo_produto_id_seq OWNED BY public.cad_tipo_produto.id;
          public          postgres    false    220            �            1259    16475    cad_usuarios    TABLE       CREATE TABLE public.cad_usuarios (
    id integer NOT NULL,
    uniqid character varying(255) NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    senha text NOT NULL,
    status boolean NOT NULL,
    dt_create timestamp without time zone NOT NULL,
    dt_update timestamp without time zone,
    dt_delete timestamp without time zone
);
     DROP TABLE public.cad_usuarios;
       public         heap    postgres    false            �            1259    16474    cad_usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cad_usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.cad_usuarios_id_seq;
       public          postgres    false    223            4           0    0    cad_usuarios_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.cad_usuarios_id_seq OWNED BY public.cad_usuarios.id;
          public          postgres    false    222            �            1259    16483    log_acessos_usuarios    TABLE     �   CREATE TABLE public.log_acessos_usuarios (
    cad_usuario_id integer NOT NULL,
    data timestamp without time zone NOT NULL
);
 (   DROP TABLE public.log_acessos_usuarios;
       public         heap    postgres    false            }           2604    16444    adm_menu id    DEFAULT     j   ALTER TABLE ONLY public.adm_menu ALTER COLUMN id SET DEFAULT nextval('public.adm_menu_id_seq'::regclass);
 :   ALTER TABLE public.adm_menu ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    214    215            ~           2604    16453    cad_compras id    DEFAULT     p   ALTER TABLE ONLY public.cad_compras ALTER COLUMN id SET DEFAULT nextval('public.cad_compras_id_seq'::regclass);
 =   ALTER TABLE public.cad_compras ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    217    217                       2604    16460    cad_produtos id    DEFAULT     r   ALTER TABLE ONLY public.cad_produtos ALTER COLUMN id SET DEFAULT nextval('public.cad_produtos_id_seq'::regclass);
 >   ALTER TABLE public.cad_produtos ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    218    219            �           2604    16471    cad_tipo_produto id    DEFAULT     z   ALTER TABLE ONLY public.cad_tipo_produto ALTER COLUMN id SET DEFAULT nextval('public.cad_tipo_produto_id_seq'::regclass);
 B   ALTER TABLE public.cad_tipo_produto ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    220    221            �           2604    16478    cad_usuarios id    DEFAULT     r   ALTER TABLE ONLY public.cad_usuarios ALTER COLUMN id SET DEFAULT nextval('public.cad_usuarios_id_seq'::regclass);
 >   ALTER TABLE public.cad_usuarios ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    222    223                       0    16441    adm_menu 
   TABLE DATA           N   COPY public.adm_menu (id, adm_menu_id, icone, nome, link, status) FROM stdin;
    public          postgres    false    215   �4       "          0    16450    cad_compras 
   TABLE DATA           `   COPY public.cad_compras (id, cad_produto_id, cad_usuario_id, quantidade, dt_compra) FROM stdin;
    public          postgres    false    217   	5       $          0    16457    cad_produtos 
   TABLE DATA           �   COPY public.cad_produtos (id, nome, descricao, preco, quantidade, imagem, dt_create, dt_update, status, cad_tipo_produto_id) FROM stdin;
    public          postgres    false    219   55       &          0    16468    cad_tipo_produto 
   TABLE DATA           [   COPY public.cad_tipo_produto (id, nome, descricao, percentual_imposto, status) FROM stdin;
    public          postgres    false    221   �5       (          0    16475    cad_usuarios 
   TABLE DATA           o   COPY public.cad_usuarios (id, uniqid, nome, email, senha, status, dt_create, dt_update, dt_delete) FROM stdin;
    public          postgres    false    223   �5       )          0    16483    log_acessos_usuarios 
   TABLE DATA           D   COPY public.log_acessos_usuarios (cad_usuario_id, data) FROM stdin;
    public          postgres    false    224   a6       5           0    0    adm_menu_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.adm_menu_id_seq', 3, true);
          public          postgres    false    214            6           0    0    cad_compras_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.cad_compras_id_seq', 1, true);
          public          postgres    false    216            7           0    0    cad_produtos_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.cad_produtos_id_seq', 1, true);
          public          postgres    false    218            8           0    0    cad_tipo_produto_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.cad_tipo_produto_id_seq', 2, true);
          public          postgres    false    220            9           0    0    cad_usuarios_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.cad_usuarios_id_seq', 4, true);
          public          postgres    false    222            �           2606    16448    adm_menu adm_menu_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.adm_menu
    ADD CONSTRAINT adm_menu_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.adm_menu DROP CONSTRAINT adm_menu_pkey;
       public            postgres    false    215            �           2606    16455    cad_compras cad_compras_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.cad_compras
    ADD CONSTRAINT cad_compras_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.cad_compras DROP CONSTRAINT cad_compras_pkey;
       public            postgres    false    217            �           2606    16466    cad_produtos cad_produtos_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.cad_produtos
    ADD CONSTRAINT cad_produtos_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.cad_produtos DROP CONSTRAINT cad_produtos_pkey;
       public            postgres    false    219            �           2606    16473 &   cad_tipo_produto cad_tipo_produto_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.cad_tipo_produto
    ADD CONSTRAINT cad_tipo_produto_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.cad_tipo_produto DROP CONSTRAINT cad_tipo_produto_pkey;
       public            postgres    false    221            �           2606    16482    cad_usuarios cad_usuarios_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.cad_usuarios
    ADD CONSTRAINT cad_usuarios_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.cad_usuarios DROP CONSTRAINT cad_usuarios_pkey;
       public            postgres    false    223            �           2606    16486 "   adm_menu adm_menu_adm_menu_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.adm_menu
    ADD CONSTRAINT adm_menu_adm_menu_id_fkey FOREIGN KEY (adm_menu_id) REFERENCES public.adm_menu(id);
 L   ALTER TABLE ONLY public.adm_menu DROP CONSTRAINT adm_menu_adm_menu_id_fkey;
       public          postgres    false    215    3205    215            �           2606    16491 2   cad_produtos cad_produtos_cad_tipo_produto_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.cad_produtos
    ADD CONSTRAINT cad_produtos_cad_tipo_produto_id_fkey FOREIGN KEY (cad_tipo_produto_id) REFERENCES public.cad_tipo_produto(id);
 \   ALTER TABLE ONLY public.cad_produtos DROP CONSTRAINT cad_produtos_cad_tipo_produto_id_fkey;
       public          postgres    false    219    3211    221            �           2606    16496 =   log_acessos_usuarios log_acessos_usuarios_cad_usuario_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.log_acessos_usuarios
    ADD CONSTRAINT log_acessos_usuarios_cad_usuario_id_fkey FOREIGN KEY (cad_usuario_id) REFERENCES public.cad_usuarios(id);
 g   ALTER TABLE ONLY public.log_acessos_usuarios DROP CONSTRAINT log_acessos_usuarios_cad_usuario_id_fkey;
       public          postgres    false    224    223    3213                i   x�3���,-N-*�-.=��(3��/M1|2�K�
2
8K��@���32�R9C2�RR��SJK�:J@"0�6c������̼tݤ�tN��L�1z\\\ �Q3      "      x�3�4C##c]S]#�=... +��      $   Q   x�3�I-.I�)�+1l��l��";���@���Ӑ3Ə����X��T��H��������X��(j�O��ӈ+F��� |$9      &   ,   x�3�I-.I�)�K��,��/�2m���@LN#��=... �
�      (      x�%���0 ��3Eh;I�� �ǵ]�DT�bz@H�9�)53UB�M��P��Z�"#��p5=�p~�a������Z<�v�?��"niʛ��Z�&�,�d!�)Vx�cH#��LyF������ �&�      )   9   x�]ɱ�0����İ�*0|K��#{���R��+�&�;���_V�w�Sj� pp�Z     