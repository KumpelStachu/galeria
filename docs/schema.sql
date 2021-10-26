create table users (
    uid uuid not null primary key default gen_random_uuid(),
    username text not null unique,
    password text not null,
    roles jsonb default '["ROLE_USER"]'::jsonb,
    last_login timestamptz,
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table profiles (
    user_uid uuid not null primary key references users(uid) on delete cascade,
    username text not null references users(username) on update cascade,
    first_name text,
    last_name text,
    description text,
    public bool default true,
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table galleries (
    uid uuid not null primary key default gen_random_uuid(),
    name text not null,
    description text,
    user_uid uuid references users(uid) on delete set null,
    thumbnail_uid uuid,
    public bool default true,
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table images (
    uid uuid not null primary key default gen_random_uuid(),
    name text not null,
    description text,
    user_uid uuid not null references users(uid) on delete cascade,
    gallery_uid uuid not null references images(uid) on delete cascade,
    public bool default true,
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table tags (
    uid uuid not null primary key default gen_random_uuid(),
    name text not null,
    user_uid uuid not null references users(uid) on delete cascade,
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table comments (
    uid uuid not null primary key default gen_random_uuid(),
    body text not null,
    user_uid uuid references users(uid) on delete set null,
    image_uid uuid not null references users(uid) on delete cascade,
    parent_uid uuid references comments(uid),
    updated_at timestamptz not null default now(),
    created_at timestamptz not null default now()
);

create table like_profile (
    user_uid uuid not null references users(uid) on delete cascade,
    profile_uid uuid not null references profiles(user_uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (user_uid, profile_uid)
);

create table like_gallery (
    user_uid uuid not null references users(uid) on delete cascade,
    gallery_uid uuid not null references galleries(uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (user_uid, gallery_uid)
);

create table like_image (
    user_uid uuid not null references users(uid) on delete cascade,
    image_uid uuid not null references images(uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (user_uid, image_uid)
);

create table like_comment (
    user_uid uuid not null references users(uid) on delete cascade,
    comment_uid uuid not null references comments(uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (user_uid, comment_uid)
);

create table gallery_tag (
    gallery_uid uuid not null references galleries(uid) on delete cascade,
    tag_uid uuid not null references tags(uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (gallery_uid, tag_uid)
);

create table image_tag (
    image_uid uuid not null references images(uid) on delete cascade,
    tag_uid uuid not null references tags(uid) on delete cascade,
    created_at timestamptz not null default now(),
    primary key (image_uid, tag_uid)
);

alter table galleries add foreign key (thumbnail_uid) references images(uid) on delete set null;

create or replace function update_timestamp()
returns trigger as $$
begin
    new.updated_at = now();
    return new;
end;
$$ language 'plpgsql';

create or replace function create_profile()
returns trigger as $$
begin
    insert into profiles values (new.uid, new.username);
    return new;
end;
$$ language 'plpgsql';

create trigger update_users_timestamp before update on users for each row execute procedure update_timestamp();
create trigger update_profiles_timestamp before update on profiles for each row execute procedure update_timestamp();
create trigger update_galleries_timestamp before update on galleries for each row execute procedure update_timestamp();
create trigger update_images_timestamp before update on images for each row execute procedure update_timestamp();
create trigger update_tags_timestamp before update on tags for each row execute procedure update_timestamp();
create trigger update_comments_timestamp before update on comments for each row execute procedure update_timestamp();
create trigger create_profile_on_register after insert on users for each row execute procedure create_profile();
