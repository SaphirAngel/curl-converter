<?php

namespace CurlConverter\CurlParser\CurlOption;

use CurlConverter\CurlParser\OptionProcessor\HeaderProcessor;
use CurlConverter\CurlParser\OptionProcessor\ProcessorBuilder;
use Exception;

class CurlOptionBuilder
{
    private static array $longOptionsDetails = [
        "url"                           => [
            "type"        => "string",
            "name"        => "url",
            "can_be_list" => true,
            "processor"   => CurlUrlOption::class
        ],
        "dns-ipv4-addr"                 => [
            "type" => "string",
            "name" => "dns-ipv4-addr"
        ],
        "dns-ipv6-addr"                 => [
            "type" => "string",
            "name" => "dns-ipv6-addr"
        ],
        "random-file"                   => [
            "type" => "string",
            "name" => "random-file"
        ],
        "egd-file"                      => [
            "type" => "string",
            "name" => "egd-file"
        ],
        "oauth2-bearer"                 => [
            "type" => "string",
            "name" => "oauth2-bearer"
        ],
        "connect-timeout"               => [
            "type" => "string",
            "name" => "connect-timeout"
        ],
        "doh-url"                       => [
            "type" => "string",
            "name" => "doh-url"
        ],
        "ciphers"                       => [
            "type" => "string",
            "name" => "ciphers"
        ],
        "dns-interface"                 => [
            "type" => "string",
            "name" => "dns-interface"
        ],
        "disable-epsv"                  => [
            "type" => "bool",
            "name" => "disable-epsv"
        ],
        "no-disable-epsv"               => [
            "type"   => "bool",
            "name"   => "disable-epsv",
            "expand" => false
        ],
        "disallow-username-in-url"      => [
            "type" => "bool",
            "name" => "disallow-username-in-url"
        ],
        "no-disallow-username-in-url"   => [
            "type"   => "bool",
            "name"   => "disallow-username-in-url",
            "expand" => false
        ],
        "epsv"                          => [
            "type" => "bool",
            "name" => "epsv"
        ],
        "no-epsv"                       => [
            "type"   => "bool",
            "name"   => "epsv",
            "expand" => false
        ],
        "dns-servers"                   => [
            "type" => "string",
            "name" => "dns-servers"
        ],
        "trace"                         => [
            "type" => "string",
            "name" => "trace"
        ],
        "npn"                           => [
            "type" => "bool",
            "name" => "npn"
        ],
        "no-npn"                        => [
            "type"   => "bool",
            "name"   => "npn",
            "expand" => false
        ],
        "trace-ascii"                   => [
            "type" => "string",
            "name" => "trace-ascii"
        ],
        "alpn"                          => [
            "type" => "bool",
            "name" => "alpn"
        ],
        "no-alpn"                       => [
            "type"   => "bool",
            "name"   => "alpn",
            "expand" => false
        ],
        "limit-rate"                    => [
            "type" => "string",
            "name" => "limit-rate"
        ],
        "rate"                          => [
            "type" => "string",
            "name" => "rate"
        ],
        "compressed"                    => [
            "type" => "bool",
            "name" => "compressed"
        ],
        "no-compressed"                 => [
            "type"   => "bool",
            "name"   => "compressed",
            "expand" => false
        ],
        "tr-encoding"                   => [
            "type" => "bool",
            "name" => "tr-encoding"
        ],
        "no-tr-encoding"                => [
            "type"   => "bool",
            "name"   => "tr-encoding",
            "expand" => false
        ],
        "digest"                        => [
            "type" => "bool",
            "name" => "digest"
        ],
        "no-digest"                     => [
            "type"   => "bool",
            "name"   => "digest",
            "expand" => false
        ],
        "negotiate"                     => [
            "type" => "bool",
            "name" => "negotiate"
        ],
        "no-negotiate"                  => [
            "type"   => "bool",
            "name"   => "negotiate",
            "expand" => false
        ],
        "ntlm"                          => [
            "type" => "bool",
            "name" => "ntlm"
        ],
        "no-ntlm"                       => [
            "type"   => "bool",
            "name"   => "ntlm",
            "expand" => false
        ],
        "ntlm-wb"                       => [
            "type" => "bool",
            "name" => "ntlm-wb"
        ],
        "no-ntlm-wb"                    => [
            "type"   => "bool",
            "name"   => "ntlm-wb",
            "expand" => false
        ],
        "basic"                         => [
            "type" => "bool",
            "name" => "basic"
        ],
        "no-basic"                      => [
            "type"   => "bool",
            "name"   => "basic",
            "expand" => false
        ],
        "anyauth"                       => [
            "type" => "bool",
            "name" => "anyauth"
        ],
        "no-anyauth"                    => [
            "type"   => "bool",
            "name"   => "anyauth",
            "expand" => false
        ],
        "wdebug"                        => [
            "type" => "bool",
            "name" => "wdebug"
        ],
        "no-wdebug"                     => [
            "type"   => "bool",
            "name"   => "wdebug",
            "expand" => false
        ],
        "ftp-create-dirs"               => [
            "type" => "bool",
            "name" => "ftp-create-dirs"
        ],
        "no-ftp-create-dirs"            => [
            "type"   => "bool",
            "name"   => "ftp-create-dirs",
            "expand" => false
        ],
        "create-dirs"                   => [
            "type" => "bool",
            "name" => "create-dirs"
        ],
        "no-create-dirs"                => [
            "type"   => "bool",
            "name"   => "create-dirs",
            "expand" => false
        ],
        "create-file-mode"              => [
            "type" => "string",
            "name" => "create-file-mode"
        ],
        "max-redirs"                    => [
            "type" => "string",
            "name" => "max-redirs"
        ],
        "proxy-ntlm"                    => [
            "type" => "bool",
            "name" => "proxy-ntlm"
        ],
        "no-proxy-ntlm"                 => [
            "type"   => "bool",
            "name"   => "proxy-ntlm",
            "expand" => false
        ],
        "crlf"                          => [
            "type" => "bool",
            "name" => "crlf"
        ],
        "no-crlf"                       => [
            "type"   => "bool",
            "name"   => "crlf",
            "expand" => false
        ],
        "stderr"                        => [
            "type" => "string",
            "name" => "stderr"
        ],
        "aws-sigv4"                     => [
            "type" => "string",
            "name" => "aws-sigv4"
        ],
        "interface"                     => [
            "type" => "string",
            "name" => "interface"
        ],
        "krb"                           => [
            "type" => "string",
            "name" => "krb"
        ],
        "krb4"                          => [
            "type" => "string",
            "name" => "krb"
        ],
        "haproxy-protocol"              => [
            "type" => "bool",
            "name" => "haproxy-protocol"
        ],
        "no-haproxy-protocol"           => [
            "type"   => "bool",
            "name"   => "haproxy-protocol",
            "expand" => false
        ],
        "haproxy-clientip"              => [
            "type" => "string",
            "name" => "haproxy-clientip"
        ],
        "max-filesize"                  => [
            "type" => "string",
            "name" => "max-filesize"
        ],
        "disable-eprt"                  => [
            "type" => "bool",
            "name" => "disable-eprt"
        ],
        "no-disable-eprt"               => [
            "type"   => "bool",
            "name"   => "disable-eprt",
            "expand" => false
        ],
        "eprt"                          => [
            "type" => "bool",
            "name" => "eprt"
        ],
        "no-eprt"                       => [
            "type"   => "bool",
            "name"   => "eprt",
            "expand" => false
        ],
        "xattr"                         => [
            "type" => "bool",
            "name" => "xattr"
        ],
        "no-xattr"                      => [
            "type"   => "bool",
            "name"   => "xattr",
            "expand" => false
        ],
        "ftp-ssl"                       => [
            "type" => "bool",
            "name" => "ssl"
        ],
        "no-ftp-ssl"                    => [
            "type"   => "bool",
            "name"   => "ssl",
            "expand" => false
        ],
        "ssl"                           => [
            "type" => "bool",
            "name" => "ssl"
        ],
        "no-ssl"                        => [
            "type"   => "bool",
            "name"   => "ssl",
            "expand" => false
        ],
        "ftp-pasv"                      => [
            "type" => "bool",
            "name" => "ftp-pasv"
        ],
        "no-ftp-pasv"                   => [
            "type"   => "bool",
            "name"   => "ftp-pasv",
            "expand" => false
        ],
        "socks5"                        => [
            "type" => "string",
            "name" => "socks5"
        ],
        "tcp-nodelay"                   => [
            "type" => "bool",
            "name" => "tcp-nodelay"
        ],
        "no-tcp-nodelay"                => [
            "type"   => "bool",
            "name"   => "tcp-nodelay",
            "expand" => false
        ],
        "proxy-digest"                  => [
            "type" => "bool",
            "name" => "proxy-digest"
        ],
        "no-proxy-digest"               => [
            "type"   => "bool",
            "name"   => "proxy-digest",
            "expand" => false
        ],
        "proxy-basic"                   => [
            "type" => "bool",
            "name" => "proxy-basic"
        ],
        "no-proxy-basic"                => [
            "type"   => "bool",
            "name"   => "proxy-basic",
            "expand" => false
        ],
        "retry"                         => [
            "type" => "string",
            "name" => "retry"
        ],
        "retry-connrefused"             => [
            "type" => "bool",
            "name" => "retry-connrefused"
        ],
        "no-retry-connrefused"          => [
            "type"   => "bool",
            "name"   => "retry-connrefused",
            "expand" => false
        ],
        "retry-delay"                   => [
            "type" => "string",
            "name" => "retry-delay"
        ],
        "retry-max-time"                => [
            "type" => "string",
            "name" => "retry-max-time"
        ],
        "proxy-negotiate"               => [
            "type" => "bool",
            "name" => "proxy-negotiate"
        ],
        "no-proxy-negotiate"            => [
            "type"   => "bool",
            "name"   => "proxy-negotiate",
            "expand" => false
        ],
        "form-escape"                   => [
            "type" => "bool",
            "name" => "form-escape"
        ],
        "no-form-escape"                => [
            "type"   => "bool",
            "name"   => "form-escape",
            "expand" => false
        ],
        "ftp-account"                   => [
            "type" => "string",
            "name" => "ftp-account"
        ],
        "proxy-anyauth"                 => [
            "type" => "bool",
            "name" => "proxy-anyauth"
        ],
        "no-proxy-anyauth"              => [
            "type"   => "bool",
            "name"   => "proxy-anyauth",
            "expand" => false
        ],
        "trace-time"                    => [
            "type" => "bool",
            "name" => "trace-time"
        ],
        "no-trace-time"                 => [
            "type"   => "bool",
            "name"   => "trace-time",
            "expand" => false
        ],
        "ignore-content-length"         => [
            "type" => "bool",
            "name" => "ignore-content-length"
        ],
        "no-ignore-content-length"      => [
            "type"   => "bool",
            "name"   => "ignore-content-length",
            "expand" => false
        ],
        "ftp-skip-pasv-ip"              => [
            "type" => "bool",
            "name" => "ftp-skip-pasv-ip"
        ],
        "no-ftp-skip-pasv-ip"           => [
            "type"   => "bool",
            "name"   => "ftp-skip-pasv-ip",
            "expand" => false
        ],
        "ftp-method"                    => [
            "type" => "string",
            "name" => "ftp-method"
        ],
        "local-port"                    => [
            "type" => "string",
            "name" => "local-port"
        ],
        "socks4"                        => [
            "type" => "string",
            "name" => "socks4"
        ],
        "socks4a"                       => [
            "type" => "string",
            "name" => "socks4a"
        ],
        "ftp-alternative-to-user"       => [
            "type" => "string",
            "name" => "ftp-alternative-to-user"
        ],
        "ftp-ssl-reqd"                  => [
            "type" => "bool",
            "name" => "ssl-reqd"
        ],
        "no-ftp-ssl-reqd"               => [
            "type"   => "bool",
            "name"   => "ssl-reqd",
            "expand" => false
        ],
        "ssl-reqd"                      => [
            "type" => "bool",
            "name" => "ssl-reqd"
        ],
        "no-ssl-reqd"                   => [
            "type"   => "bool",
            "name"   => "ssl-reqd",
            "expand" => false
        ],
        "sessionid"                     => [
            "type" => "bool",
            "name" => "sessionid"
        ],
        "no-sessionid"                  => [
            "type"   => "bool",
            "name"   => "sessionid",
            "expand" => false
        ],
        "ftp-ssl-control"               => [
            "type" => "bool",
            "name" => "ftp-ssl-control"
        ],
        "no-ftp-ssl-control"            => [
            "type"   => "bool",
            "name"   => "ftp-ssl-control",
            "expand" => false
        ],
        "ftp-ssl-ccc"                   => [
            "type" => "bool",
            "name" => "ftp-ssl-ccc"
        ],
        "no-ftp-ssl-ccc"                => [
            "type"   => "bool",
            "name"   => "ftp-ssl-ccc",
            "expand" => false
        ],
        "ftp-ssl-ccc-mode"              => [
            "type" => "string",
            "name" => "ftp-ssl-ccc-mode"
        ],
        "libcurl"                       => [
            "type" => "string",
            "name" => "libcurl"
        ],
        "raw"                           => [
            "type" => "bool",
            "name" => "raw"
        ],
        "no-raw"                        => [
            "type"   => "bool",
            "name"   => "raw",
            "expand" => false
        ],
        "post301"                       => [
            "type" => "bool",
            "name" => "post301"
        ],
        "no-post301"                    => [
            "type"   => "bool",
            "name"   => "post301",
            "expand" => false
        ],
        "keepalive"                     => [
            "type" => "bool",
            "name" => "keepalive"
        ],
        "no-keepalive"                  => [
            "type"   => "bool",
            "name"   => "keepalive",
            "expand" => false
        ],
        "socks5-hostname"               => [
            "type" => "string",
            "name" => "socks5-hostname"
        ],
        "keepalive-time"                => [
            "type" => "string",
            "name" => "keepalive-time"
        ],
        "post302"                       => [
            "type" => "bool",
            "name" => "post302"
        ],
        "no-post302"                    => [
            "type"   => "bool",
            "name"   => "post302",
            "expand" => false
        ],
        "noproxy"                       => [
            "type" => "string",
            "name" => "noproxy"
        ],
        "socks5-gssapi-nec"             => [
            "type" => "bool",
            "name" => "socks5-gssapi-nec"
        ],
        "no-socks5-gssapi-nec"          => [
            "type"   => "bool",
            "name"   => "socks5-gssapi-nec",
            "expand" => false
        ],
        "proxy1.0"                      => [
            "type" => "string",
            "name" => "proxy1.0"
        ],
        "tftp-blksize"                  => [
            "type" => "string",
            "name" => "tftp-blksize"
        ],
        "mail-from"                     => [
            "type" => "string",
            "name" => "mail-from"
        ],
        "mail-rcpt"                     => [
            "type"        => "string",
            "name"        => "mail-rcpt",
            "can_be_list" => true
        ],
        "ftp-pret"                      => [
            "type" => "bool",
            "name" => "ftp-pret"
        ],
        "no-ftp-pret"                   => [
            "type"   => "bool",
            "name"   => "ftp-pret",
            "expand" => false
        ],
        "proto"                         => [
            "type" => "string",
            "name" => "proto"
        ],
        "proto-redir"                   => [
            "type" => "string",
            "name" => "proto-redir"
        ],
        "resolve"                       => [
            "type"        => "string",
            "name"        => "resolve",
            "can_be_list" => true
        ],
        "delegation"                    => [
            "type" => "string",
            "name" => "delegation"
        ],
        "mail-auth"                     => [
            "type" => "string",
            "name" => "mail-auth"
        ],
        "post303"                       => [
            "type" => "bool",
            "name" => "post303"
        ],
        "no-post303"                    => [
            "type"   => "bool",
            "name"   => "post303",
            "expand" => false
        ],
        "metalink"                      => [
            "type" => "bool",
            "name" => "metalink"
        ],
        "no-metalink"                   => [
            "type"   => "bool",
            "name"   => "metalink",
            "expand" => false
        ],
        "sasl-authzid"                  => [
            "type" => "string",
            "name" => "sasl-authzid"
        ],
        "sasl-ir"                       => [
            "type" => "bool",
            "name" => "sasl-ir"
        ],
        "no-sasl-ir"                    => [
            "type"   => "bool",
            "name"   => "sasl-ir",
            "expand" => false
        ],
        "test-event"                    => [
            "type" => "bool",
            "name" => "test-event"
        ],
        "no-test-event"                 => [
            "type"   => "bool",
            "name"   => "test-event",
            "expand" => false
        ],
        "unix-socket"                   => [
            "type" => "string",
            "name" => "unix-socket"
        ],
        "path-as-is"                    => [
            "type" => "bool",
            "name" => "path-as-is"
        ],
        "no-path-as-is"                 => [
            "type"   => "bool",
            "name"   => "path-as-is",
            "expand" => false
        ],
        "socks5-gssapi-service"         => [
            "type" => "string",
            "name" => "proxy-service-name"
        ],
        "proxy-service-name"            => [
            "type" => "string",
            "name" => "proxy-service-name"
        ],
        "service-name"                  => [
            "type" => "string",
            "name" => "service-name"
        ],
        "proto-default"                 => [
            "type" => "string",
            "name" => "proto-default"
        ],
        "expect100-timeout"             => [
            "type" => "string",
            "name" => "expect100-timeout"
        ],
        "tftp-no-options"               => [
            "type" => "bool",
            "name" => "tftp-no-options"
        ],
        "no-tftp-no-options"            => [
            "type"   => "bool",
            "name"   => "tftp-no-options",
            "expand" => false
        ],
        "connect-to"                    => [
            "type"        => "string",
            "name"        => "connect-to",
            "can_be_list" => true
        ],
        "abstract-unix-socket"          => [
            "type" => "string",
            "name" => "abstract-unix-socket"
        ],
        "tls-max"                       => [
            "type" => "string",
            "name" => "tls-max"
        ],
        "suppress-connect-headers"      => [
            "type" => "bool",
            "name" => "suppress-connect-headers"
        ],
        "no-suppress-connect-headers"   => [
            "type"   => "bool",
            "name"   => "suppress-connect-headers",
            "expand" => false
        ],
        "compressed-ssh"                => [
            "type" => "bool",
            "name" => "compressed-ssh"
        ],
        "no-compressed-ssh"             => [
            "type"   => "bool",
            "name"   => "compressed-ssh",
            "expand" => false
        ],
        "happy-eyeballs-timeout-ms"     => [
            "type" => "string",
            "name" => "happy-eyeballs-timeout-ms"
        ],
        "retry-all-errors"              => [
            "type" => "bool",
            "name" => "retry-all-errors"
        ],
        "no-retry-all-errors"           => [
            "type"   => "bool",
            "name"   => "retry-all-errors",
            "expand" => false
        ],
        "trace-ids"                     => [
            "type" => "bool",
            "name" => "trace-ids"
        ],
        "no-trace-ids"                  => [
            "type"   => "bool",
            "name"   => "trace-ids",
            "expand" => false
        ],
        "http1.0"                       => [
            "type"  => "bool",
            "name"  => "http1.0",
            "short" => "0"
        ],
        "http1.1"                       => [
            "type" => "bool",
            "name" => "http1.1"
        ],
        "http2"                         => [
            "type" => "bool",
            "name" => "http2"
        ],
        "http2-prior-knowledge"         => [
            "type" => "bool",
            "name" => "http2-prior-knowledge"
        ],
        "http3"                         => [
            "type" => "bool",
            "name" => "http3"
        ],
        "http3-only"                    => [
            "type" => "bool",
            "name" => "http3-only"
        ],
        "http0.9"                       => [
            "type" => "bool",
            "name" => "http0.9"
        ],
        "no-http0.9"                    => [
            "type"   => "bool",
            "name"   => "http0.9",
            "expand" => false
        ],
        "proxy-http2"                   => [
            "type" => "bool",
            "name" => "proxy-http2"
        ],
        "no-proxy-http2"                => [
            "type"   => "bool",
            "name"   => "proxy-http2",
            "expand" => false
        ],
        "tlsv1"                         => [
            "type"  => "bool",
            "name"  => "tlsv1",
            "short" => "1"
        ],
        "tlsv1.0"                       => [
            "type" => "bool",
            "name" => "tlsv1.0"
        ],
        "tlsv1.1"                       => [
            "type" => "bool",
            "name" => "tlsv1.1"
        ],
        "tlsv1.2"                       => [
            "type" => "bool",
            "name" => "tlsv1.2"
        ],
        "tlsv1.3"                       => [
            "type" => "bool",
            "name" => "tlsv1.3"
        ],
        "tls13-ciphers"                 => [
            "type" => "string",
            "name" => "tls13-ciphers"
        ],
        "proxy-tls13-ciphers"           => [
            "type" => "string",
            "name" => "proxy-tls13-ciphers"
        ],
        "sslv2"                         => [
            "type"  => "bool",
            "name"  => "sslv2",
            "short" => "2"
        ],
        "sslv3"                         => [
            "type"  => "bool",
            "name"  => "sslv3",
            "short" => "3"
        ],
        "ipv4"                          => [
            "type"  => "bool",
            "name"  => "ipv4",
            "short" => "4"
        ],
        "ipv6"                          => [
            "type"  => "bool",
            "name"  => "ipv6",
            "short" => "6"
        ],
        "append"                        => [
            "type"  => "bool",
            "name"  => "append",
            "short" => "a"
        ],
        "no-append"                     => [
            "type"   => "bool",
            "name"   => "append",
            "expand" => false
        ],
        "user-agent"                    => [
            "type"  => "string",
            "name"  => "user-agent",
            "short" => "A"
        ],
        "cookie"                        => [
            "type"        => "string",
            "name"        => "cookie",
            "short"       => "b",
            "can_be_list" => true,
            "processor"   => CurlCookieOption::class
        ],
        "alt-svc"                       => [
            "type" => "string",
            "name" => "alt-svc"
        ],
        "hsts"                          => [
            "type"        => "string",
            "name"        => "hsts",
            "can_be_list" => true
        ],
        "use-ascii"                     => [
            "type"  => "bool",
            "name"  => "use-ascii",
            "short" => "B"
        ],
        "no-use-ascii"                  => [
            "type"   => "bool",
            "name"   => "use-ascii",
            "expand" => false
        ],
        "cookie-jar"                    => [
            "type"  => "string",
            "name"  => "cookie-jar",
            "short" => "c"
        ],
        "continue-at"                   => [
            "type"  => "string",
            "name"  => "continue-at",
            "short" => "C"
        ],
        "data"                          => [
            "type"        => "string",
            "name"        => "data",
            "short"       => "d",
            "can_be_list" => true,
            "processor"   => CurlDataOption::class
        ],
        "data-raw"                      => [
            "type" => "string",
            "name" => "data-raw"
        ],
        "data-ascii"                    => [
            "type" => "string",
            "name" => "data-ascii"
        ],
        "data-binary"                   => [
            "type" => "string",
            "name" => "data-binary"
        ],
        "data-urlencode"                => [
            "type" => "string",
            "name" => "data-urlencode"
        ],
        "json"                          => [
            "type"      => "string",
            "name"      => "json",
            "processor" => CurlDataOption::class
        ],
        "url-query"                     => [
            "type"        => "string",
            "name"        => "url-query",
            "can_be_list" => true
        ],
        "dump-header"                   => [
            "type"  => "string",
            "name"  => "dump-header",
            "short" => "D"
        ],
        "referer"                       => [
            "type"  => "string",
            "name"  => "referer",
            "short" => "r"
        ],
        "cert"                          => [
            "type"  => "string",
            "name"  => "cert",
            "short" => "E"
        ],
        "cacert"                        => [
            "type" => "string",
            "name" => "cacert"
        ],
        "cert-type"                     => [
            "type" => "string",
            "name" => "cert-type"
        ],
        "key"                           => [
            "type" => "string",
            "name" => "key"
        ],
        "key-type"                      => [
            "type" => "string",
            "name" => "key-type"
        ],
        "pass"                          => [
            "type" => "string",
            "name" => "pass"
        ],
        "engine"                        => [
            "type" => "string",
            "name" => "engine"
        ],
        "ca-native"                     => [
            "type" => "bool",
            "name" => "ca-native"
        ],
        "no-ca-native"                  => [
            "type"   => "bool",
            "name"   => "ca-native",
            "expand" => false
        ],
        "proxy-ca-native"               => [
            "type" => "bool",
            "name" => "proxy-ca-native"
        ],
        "no-proxy-ca-native"            => [
            "type"   => "bool",
            "name"   => "proxy-ca-native",
            "expand" => false
        ],
        "capath"                        => [
            "type" => "string",
            "name" => "capath"
        ],
        "pubkey"                        => [
            "type" => "string",
            "name" => "pubkey"
        ],
        "hostpubmd5"                    => [
            "type" => "string",
            "name" => "hostpubmd5"
        ],
        "hostpubsha256"                 => [
            "type" => "string",
            "name" => "hostpubsha256"
        ],
        "crlfile"                       => [
            "type" => "string",
            "name" => "crlfile"
        ],
        "tlsuser"                       => [
            "type" => "string",
            "name" => "tlsuser"
        ],
        "tlspassword"                   => [
            "type" => "string",
            "name" => "tlspassword"
        ],
        "tlsauthtype"                   => [
            "type" => "string",
            "name" => "tlsauthtype"
        ],
        "ssl-allow-beast"               => [
            "type" => "bool",
            "name" => "ssl-allow-beast"
        ],
        "no-ssl-allow-beast"            => [
            "type"   => "bool",
            "name"   => "ssl-allow-beast",
            "expand" => false
        ],
        "ssl-auto-client-cert"          => [
            "type" => "bool",
            "name" => "ssl-auto-client-cert"
        ],
        "no-ssl-auto-client-cert"       => [
            "type"   => "bool",
            "name"   => "ssl-auto-client-cert",
            "expand" => false
        ],
        "proxy-ssl-auto-client-cert"    => [
            "type" => "bool",
            "name" => "proxy-ssl-auto-client-cert"
        ],
        "no-proxy-ssl-auto-client-cert" => [
            "type"   => "bool",
            "name"   => "proxy-ssl-auto-client-cert",
            "expand" => false
        ],
        "pinnedpubkey"                  => [
            "type" => "string",
            "name" => "pinnedpubkey"
        ],
        "proxy-pinnedpubkey"            => [
            "type" => "string",
            "name" => "proxy-pinnedpubkey"
        ],
        "cert-status"                   => [
            "type" => "bool",
            "name" => "cert-status"
        ],
        "no-cert-status"                => [
            "type"   => "bool",
            "name"   => "cert-status",
            "expand" => false
        ],
        "doh-cert-status"               => [
            "type" => "bool",
            "name" => "doh-cert-status"
        ],
        "no-doh-cert-status"            => [
            "type"   => "bool",
            "name"   => "doh-cert-status",
            "expand" => false
        ],
        "false-start"                   => [
            "type" => "bool",
            "name" => "false-start"
        ],
        "no-false-start"                => [
            "type"   => "bool",
            "name"   => "false-start",
            "expand" => false
        ],
        "ssl-no-revoke"                 => [
            "type" => "bool",
            "name" => "ssl-no-revoke"
        ],
        "no-ssl-no-revoke"              => [
            "type"   => "bool",
            "name"   => "ssl-no-revoke",
            "expand" => false
        ],
        "ssl-revoke-best-effort"        => [
            "type" => "bool",
            "name" => "ssl-revoke-best-effort"
        ],
        "no-ssl-revoke-best-effort"     => [
            "type"   => "bool",
            "name"   => "ssl-revoke-best-effort",
            "expand" => false
        ],
        "tcp-fastopen"                  => [
            "type" => "bool",
            "name" => "tcp-fastopen"
        ],
        "no-tcp-fastopen"               => [
            "type"   => "bool",
            "name"   => "tcp-fastopen",
            "expand" => false
        ],
        "proxy-tlsuser"                 => [
            "type" => "string",
            "name" => "proxy-tlsuser"
        ],
        "proxy-tlspassword"             => [
            "type" => "string",
            "name" => "proxy-tlspassword"
        ],
        "proxy-tlsauthtype"             => [
            "type" => "string",
            "name" => "proxy-tlsauthtype"
        ],
        "proxy-cert"                    => [
            "type" => "string",
            "name" => "proxy-cert"
        ],
        "proxy-cert-type"               => [
            "type" => "string",
            "name" => "proxy-cert-type"
        ],
        "proxy-key"                     => [
            "type" => "string",
            "name" => "proxy-key"
        ],
        "proxy-key-type"                => [
            "type" => "string",
            "name" => "proxy-key-type"
        ],
        "proxy-pass"                    => [
            "type" => "string",
            "name" => "proxy-pass"
        ],
        "proxy-ciphers"                 => [
            "type" => "string",
            "name" => "proxy-ciphers"
        ],
        "proxy-crlfile"                 => [
            "type" => "string",
            "name" => "proxy-crlfile"
        ],
        "proxy-ssl-allow-beast"         => [
            "type" => "bool",
            "name" => "proxy-ssl-allow-beast"
        ],
        "no-proxy-ssl-allow-beast"      => [
            "type"   => "bool",
            "name"   => "proxy-ssl-allow-beast",
            "expand" => false
        ],
        "login-options"                 => [
            "type" => "string",
            "name" => "login-options"
        ],
        "proxy-cacert"                  => [
            "type" => "string",
            "name" => "proxy-cacert"
        ],
        "proxy-capath"                  => [
            "type" => "string",
            "name" => "proxy-capath"
        ],
        "proxy-insecure"                => [
            "type" => "bool",
            "name" => "proxy-insecure"
        ],
        "no-proxy-insecure"             => [
            "type"   => "bool",
            "name"   => "proxy-insecure",
            "expand" => false
        ],
        "proxy-tlsv1"                   => [
            "type" => "bool",
            "name" => "proxy-tlsv1"
        ],
        "socks5-basic"                  => [
            "type" => "bool",
            "name" => "socks5-basic"
        ],
        "no-socks5-basic"               => [
            "type"   => "bool",
            "name"   => "socks5-basic",
            "expand" => false
        ],
        "socks5-gssapi"                 => [
            "type" => "bool",
            "name" => "socks5-gssapi"
        ],
        "no-socks5-gssapi"              => [
            "type"   => "bool",
            "name"   => "socks5-gssapi",
            "expand" => false
        ],
        "etag-save"                     => [
            "type" => "string",
            "name" => "etag-save"
        ],
        "etag-compare"                  => [
            "type" => "string",
            "name" => "etag-compare"
        ],
        "curves"                        => [
            "type" => "string",
            "name" => "curves"
        ],
        "fail"                          => [
            "type"  => "bool",
            "name"  => "fail",
            "short" => "f"
        ],
        "no-fail"                       => [
            "type"   => "bool",
            "name"   => "fail",
            "expand" => false
        ],
        "fail-early"                    => [
            "type" => "bool",
            "name" => "fail-early"
        ],
        "no-fail-early"                 => [
            "type"   => "bool",
            "name"   => "fail-early",
            "expand" => false
        ],
        "styled-output"                 => [
            "type" => "bool",
            "name" => "styled-output"
        ],
        "no-styled-output"              => [
            "type"   => "bool",
            "name"   => "styled-output",
            "expand" => false
        ],
        "mail-rcpt-allowfails"          => [
            "type" => "bool",
            "name" => "mail-rcpt-allowfails"
        ],
        "no-mail-rcpt-allowfails"       => [
            "type"   => "bool",
            "name"   => "mail-rcpt-allowfails",
            "expand" => false
        ],
        "fail-with-body"                => [
            "type" => "bool",
            "name" => "fail-with-body"
        ],
        "no-fail-with-body"             => [
            "type"   => "bool",
            "name"   => "fail-with-body",
            "expand" => false
        ],
        "remove-on-error"               => [
            "type" => "bool",
            "name" => "remove-on-error"
        ],
        "no-remove-on-error"            => [
            "type"   => "bool",
            "name"   => "remove-on-error",
            "expand" => false
        ],
        "form"                          => [
            "type"        => "string",
            "name"        => "form",
            "short"       => "F",
            "can_be_list" => true
        ],
        "form-string"                   => [
            "type" => "string",
            "name" => "form-string"
        ],
        "globoff"                       => [
            "type"  => "bool",
            "name"  => "globoff",
            "short" => "g"
        ],
        "no-globoff"                    => [
            "type"   => "bool",
            "name"   => "globoff",
            "expand" => false
        ],
        "get"                           => [
            "type"  => "bool",
            "name"  => "get",
            "short" => "G"
        ],
        "no-get"                        => [
            "type"   => "bool",
            "name"   => "get",
            "expand" => false
        ],
        "request-target"                => [
            "type" => "string",
            "name" => "request-target"
        ],
        "help"                          => [
            "type"  => "bool",
            "name"  => "help",
            "short" => "h"
        ],
        "no-help"                       => [
            "type"   => "bool",
            "name"   => "help",
            "expand" => false
        ],
        "header"                        => [
            "type"        => "string",
            "name"        => "header",
            "processor"   => CurlHeaderOption::class,
            "short"       => "H",
            "can_be_list" => true
        ],
        "proxy-header"                  => [
            "type"        => "string",
            "name"        => "proxy-header",
            "can_be_list" => true
        ],
        "include"                       => [
            "type" => "bool",
            "name" => "include"
        ],
        "no-include"                    => [
            "type"   => "bool",
            "name"   => "include",
            "expand" => false
        ],
        "head"                          => [
            "type" => "bool",
            "name" => "head"
        ],
        "no-head"                       => [
            "type"   => "bool",
            "name"   => "head",
            "expand" => false
        ],
        "junk-session-cookies"          => [
            "type" => "bool",
            "name" => "junk-session-cookies"
        ],
        "no-junk-session-cookies"       => [
            "type"   => "bool",
            "name"   => "junk-session-cookies",
            "expand" => false
        ],
        "remote-header-name"            => [
            "type" => "bool",
            "name" => "remote-header-name"
        ],
        "no-remote-header-name"         => [
            "type"   => "bool",
            "name"   => "remote-header-name",
            "expand" => false
        ],
        "insecure"                      => [
            "type" => "bool",
            "name" => "insecure"
        ],
        "no-insecure"                   => [
            "type"   => "bool",
            "name"   => "insecure",
            "expand" => false
        ],
        "doh-insecure"                  => [
            "type" => "bool",
            "name" => "doh-insecure"
        ],
        "no-doh-insecure"               => [
            "type"   => "bool",
            "name"   => "doh-insecure",
            "expand" => false
        ],
        "config"                        => [
            "type" => "string",
            "name" => "config"
        ],
        "list-only"                     => [
            "type" => "bool",
            "name" => "list-only"
        ],
        "no-list-only"                  => [
            "type"   => "bool",
            "name"   => "list-only",
            "expand" => false
        ],
        "location"                      => [
            "type" => "bool",
            "name" => "location"
        ],
        "no-location"                   => [
            "type"   => "bool",
            "name"   => "location",
            "expand" => false
        ],
        "location-trusted"              => [
            "type" => "bool",
            "name" => "location-trusted"
        ],
        "no-location-trusted"           => [
            "type"   => "bool",
            "name"   => "location-trusted",
            "expand" => false
        ],
        "max-time"                      => [
            "type"          => "string",
            "name"          => "max-time",
            "internal_name" => "timeout"
        ],
        "manual"                        => [
            "type" => "bool",
            "name" => "manual"
        ],
        "no-manual"                     => [
            "type"   => "bool",
            "name"   => "manual",
            "expand" => false
        ],
        "netrc"                         => [
            "type" => "bool",
            "name" => "netrc"
        ],
        "no-netrc"                      => [
            "type"   => "bool",
            "name"   => "netrc",
            "expand" => false
        ],
        "netrc-optional"                => [
            "type" => "bool",
            "name" => "netrc-optional"
        ],
        "no-netrc-optional"             => [
            "type"   => "bool",
            "name"   => "netrc-optional",
            "expand" => false
        ],
        "netrc-file"                    => [
            "type" => "string",
            "name" => "netrc-file"
        ],
        "buffer"                        => [
            "type" => "bool",
            "name" => "buffer"
        ],
        "no-buffer"                     => [
            "type"   => "bool",
            "name"   => "buffer",
            "expand" => false
        ],
        "output"                        => [
            "type"        => "string",
            "name"        => "output",
            "can_be_list" => true
        ],
        "remote-name"                   => [
            "type" => "bool",
            "name" => "remote-name"
        ],
        "no-remote-name"                => [
            "type"   => "bool",
            "name"   => "remote-name",
            "expand" => false
        ],
        "remote-name-all"               => [
            "type" => "bool",
            "name" => "remote-name-all"
        ],
        "no-remote-name-all"            => [
            "type"   => "bool",
            "name"   => "remote-name-all",
            "expand" => false
        ],
        "output-dir"                    => [
            "type" => "string",
            "name" => "output-dir"
        ],
        "clobber"                       => [
            "type" => "bool",
            "name" => "clobber"
        ],
        "no-clobber"                    => [
            "type"   => "bool",
            "name"   => "clobber",
            "expand" => false
        ],
        "proxytunnel"                   => [
            "type" => "bool",
            "name" => "proxytunnel"
        ],
        "no-proxytunnel"                => [
            "type"   => "bool",
            "name"   => "proxytunnel",
            "expand" => false
        ],
        "ftp-port"                      => [
            "type" => "string",
            "name" => "ftp-port"
        ],
        "disable"                       => [
            "type" => "bool",
            "name" => "disable"
        ],
        "no-disable"                    => [
            "type"   => "bool",
            "name"   => "disable",
            "expand" => false
        ],
        "quote"                         => [
            "type"        => "string",
            "name"        => "quote",
            "can_be_list" => true
        ],
        "range"                         => [
            "type" => "string",
            "name" => "range"
        ],
        "remote-time"                   => [
            "type" => "bool",
            "name" => "remote-time"
        ],
        "no-remote-time"                => [
            "type"   => "bool",
            "name"   => "remote-time",
            "expand" => false
        ],
        "silent"                        => [
            "type" => "bool",
            "name" => "silent"
        ],
        "no-silent"                     => [
            "type"   => "bool",
            "name"   => "silent",
            "expand" => false
        ],
        "show-error"                    => [
            "type" => "bool",
            "name" => "show-error"
        ],
        "no-show-error"                 => [
            "type"   => "bool",
            "name"   => "show-error",
            "expand" => false
        ],
        "telnet-option"                 => [
            "type"        => "string",
            "name"        => "telnet-option",
            "can_be_list" => true
        ],
        "upload-file"                   => [
            "type"        => "string",
            "name"        => "upload-file",
            "can_be_list" => true
        ],
        "user"                          => [
            "type" => "string",
            "name" => "user"
        ],
        "proxy-user"                    => [
            "type" => "string",
            "name" => "proxy-user"
        ],
        "verbose"                       => [
            "type" => "bool",
            "name" => "verbose"
        ],
        "no-verbose"                    => [
            "type"   => "bool",
            "name"   => "verbose",
            "expand" => false
        ],
        "version"                       => [
            "type" => "bool",
            "name" => "version"
        ],
        "no-version"                    => [
            "type"   => "bool",
            "name"   => "version",
            "expand" => false
        ],
        "write-out"                     => [
            "type" => "string",
            "name" => "write-out"
        ],
        "proxy"                         => [
            "type" => "string",
            "name" => "proxy"
        ],
        "preproxy"                      => [
            "type" => "string",
            "name" => "preproxy"
        ],
        "request"                       => [
            "type"          => "string",
            "name"          => "request",
            "internal_name" => "method"
        ],
        "speed-limit"                   => [
            "type" => "string",
            "name" => "speed-limit"
        ],
        "speed-time"                    => [
            "type" => "string",
            "name" => "speed-time"
        ],
        "time-cond"                     => [
            "type" => "string",
            "name" => "time-cond"
        ],
        "parallel"                      => [
            "type" => "bool",
            "name" => "parallel"
        ],
        "no-parallel"                   => [
            "type"   => "bool",
            "name"   => "parallel",
            "expand" => false
        ],
        "parallel-max"                  => [
            "type" => "string",
            "name" => "parallel-max"
        ],
        "parallel-immediate"            => [
            "type" => "bool",
            "name" => "parallel-immediate"
        ],
        "no-parallel-immediate"         => [
            "type"   => "bool",
            "name"   => "parallel-immediate",
            "expand" => false
        ],
        "progress-bar"                  => [
            "type" => "bool",
            "name" => "progress-bar"
        ],
        "no-progress-bar"               => [
            "type"   => "bool",
            "name"   => "progress-bar",
            "expand" => false
        ],
        "progress-meter"                => [
            "type" => "bool",
            "name" => "progress-meter"
        ],
        "no-progress-meter"             => [
            "type"   => "bool",
            "name"   => "progress-meter",
            "expand" => false
        ],
        "next"                          => [
            "type" => "bool",
            "name" => "next"
        ],
        "port"                          => [
            "type"    => "string",
            "name"    => "port",
            "removed" => "7.3"
        ],
        "ftp-ascii"                     => [
            "type"    => "bool",
            "name"    => "use-ascii",
            "removed" => "7.10.7"
        ],
        "3p-url"                        => [
            "type"    => "string",
            "name"    => "3p-url",
            "removed" => "7.16.0"
        ],
        "3p-user"                       => [
            "type"    => "string",
            "name"    => "3p-user",
            "removed" => "7.16.0"
        ],
        "3p-quote"                      => [
            "type"    => "string",
            "name"    => "3p-quote",
            "removed" => "7.16.0"
        ],
        "http2.0"                       => [
            "type"    => "bool",
            "name"    => "http2",
            "removed" => "7.36.0"
        ],
        "no-http2.0"                    => [
            "type"    => "bool",
            "name"    => "http2",
            "removed" => "7.36.0"
        ],
        "telnet-options"                => [
            "type"    => "string",
            "name"    => "telnet-option",
            "removed" => "7.49.0"
        ],
        "http-request"                  => [
            "type"    => "string",
            "name"    => "request",
            "removed" => "7.49.0"
        ],
        "capath "                       => [
            "type"    => "string",
            "name"    => "capath",
            "removed" => "7.49.0"
        ],
        "ftpport"                       => [
            "type"    => "string",
            "name"    => "ftp-port",
            "removed" => "7.49.0"
        ],
        "environment"                   => [
            "type"    => "bool",
            "name"    => "environment",
            "removed" => "7.54.1"
        ],
        "no-tlsv1"                      => [
            "type"    => "bool",
            "name"    => "tlsv1",
            "removed" => "7.54.1"
        ],
        "no-tlsv1.2"                    => [
            "type"    => "bool",
            "name"    => "tlsv1.2",
            "removed" => "7.54.1"
        ],
        "no-http2-prior-knowledge"      => [
            "type"    => "bool",
            "name"    => "http2-prior-knowledge",
            "removed" => "7.54.1"
        ],
        "no-ipv6"                       => [
            "type"    => "bool",
            "name"    => "ipv6",
            "removed" => "7.54.1"
        ],
        "no-ipv4"                       => [
            "type"    => "bool",
            "name"    => "ipv4",
            "removed" => "7.54.1"
        ],
        "no-sslv2"                      => [
            "type"    => "bool",
            "name"    => "sslv2",
            "removed" => "7.54.1"
        ],
        "no-tlsv1.0"                    => [
            "type"    => "bool",
            "name"    => "tlsv1.0",
            "removed" => "7.54.1"
        ],
        "no-tlsv1.1"                    => [
            "type"    => "bool",
            "name"    => "tlsv1.1",
            "removed" => "7.54.1"
        ],
        "no-sslv3"                      => [
            "type"    => "bool",
            "name"    => "sslv3",
            "removed" => "7.54.1"
        ],
        "no-http1.0"                    => [
            "type"    => "bool",
            "name"    => "http1.0",
            "removed" => "7.54.1"
        ],
        "no-next"                       => [
            "type"    => "bool",
            "name"    => "next",
            "removed" => "7.54.1"
        ],
        "no-tlsv1.3"                    => [
            "type"    => "bool",
            "name"    => "tlsv1.3",
            "removed" => "7.54.1"
        ],
        "no-environment"                => [
            "type"    => "bool",
            "name"    => "environment",
            "removed" => "7.54.1"
        ],
        "no-http1.1"                    => [
            "type"    => "bool",
            "name"    => "http1.1",
            "removed" => "7.54.1"
        ],
        "no-proxy-tlsv1"                => [
            "type"    => "bool",
            "name"    => "proxy-tlsv1",
            "removed" => "7.54.1"
        ],
        "no-http2"                      => [
            "type"    => "bool",
            "name"    => "http2",
            "removed" => "7.54.1"
        ]
    ];


    private static array $shortOptionToLongOptionNames = [
        "0"  => "http1.0",
        "1"  => "tlsv1",
        "2"  => "sslv2",
        "3"  => "sslv3",
        "4"  => "ipv4",
        "6"  => "ipv6",
        "a"  => "append",
        "A"  => "user-agent",
        "b"  => "cookie",
        "B"  => "use-ascii",
        "c"  => "cookie-jar",
        "C"  => "continue-at",
        "d"  => "data",
        "D"  => "dump-header",
        "e"  => "referer",
        "E"  => "cert",
        "f"  => "fail",
        "F"  => "form",
        "g"  => "globoff",
        "G"  => "get",
        "h"  => "help",
        "H"  => "header",
        "i"  => "include",
        "I"  => "head",
        "j"  => "junk-session-cookies",
        "J"  => "remote-header-name",
        "k"  => "insecure",
        "K"  => "config",
        "l"  => "list-only",
        "L"  => "location",
        "m"  => "max-time",
        "M"  => "manual",
        "n"  => "netrc",
        "N"  => "no-buffer",
        "o"  => "output",
        "O"  => "remote-name",
        "p"  => "proxytunnel",
        "P"  => "ftp-port",
        "q"  => "disable",
        "Q"  => "quote",
        "r"  => "range",
        "R"  => "remote-time",
        "s"  => "silent",
        "S"  => "show-error",
        "t"  => "telnet-option",
        "T"  => "upload-file",
        "u"  => "user",
        "U"  => "proxy-user",
        "v"  => "verbose",
        "V"  => "version",
        "w"  => "write-out",
        "x"  => "proxy",
        "X"  => "request",
        "Y"  => "speed-limit",
        "y"  => "speed-time",
        "z"  => "time-cond",
        "Z"  => "parallel",
        "#"  => "progress-bar",
        "=>" => "next",
    ];

    /**
     * @throws Exception
     */
    public static function getDetailsForShortOptionName(string $shortOptionName): ?AbstractCurlOption
    {
        $optionName = self::$shortOptionToLongOptionNames[$shortOptionName] ?? null;

        if (empty($optionName)) {
            throw new Exception("Unknown short option name");
        }

        return self::getOption($optionName);
    }

    /**
     * @throws Exception
     */
    public static function getOption(string $optionName): ?AbstractCurlOption
    {
        if (empty(self::$longOptionsDetails[$optionName])) {
            throw new Exception("Unknown option name");
        }

        if (!empty(self::$longOptionsDetails[$optionName]['processor'])) {
            $curlOptionEntity = self::$longOptionsDetails[$optionName]['processor'];
        } else {
            $curlOptionEntity = match (self::$longOptionsDetails[$optionName]['type']) {
                'bool' => CurlBooleanOption::class,
                'string' => CurlStringOption::class
            };
        }

        if (empty($curlOptionEntity)) {
            return null;
        }

        return new $curlOptionEntity(
            $optionName,
            self::$longOptionsDetails[$optionName]['name'],
            self::$longOptionsDetails[$optionName]['type'],
            self::$longOptionsDetails[$optionName]['expand'] ?? true,
            self::$longOptionsDetails[$optionName]['can_be_list'] ?? false,
            self::$longOptionsDetails[$optionName]['removed'] ?? null,
            self::$longOptionsDetails[$optionName]['internal_name'] ?? null
        );
    }
}
