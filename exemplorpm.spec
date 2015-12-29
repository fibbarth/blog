###########NUNCA GERAR O PACOTE EM PRODUÇÃO OU HOMOLOGAÇÃO###########
###########SOMENTE GERAR PACOTE EM DESENVOLVIMENTO###########
#Dado um número de versão MAJOR.MINOR.PATCH, incremente a:
#versão Maior(MAJOR): quando fizer mudanças incompatíveis na API,
#versão Menor(MINOR): quando adicionar funcionalidades mantendo compatibilidade, e
#versão de Correção(PATCH): quando corrigir falhas mantendo compatibilidade.
#Rótulos adicionais para pré-lançamento(pre-release) e metadados de construção(build) estão disponíveis como extensão ao formato MAJOR.MINOR.PATCH.

#Versão do pacote seguindo as regras acima
%define version 1.13.100
#Release que será liberado o pacote
%define release homologaweb
#Revisão para fazer o export
%define revision HEAD
#nome do pacote é usado para criar o RPM
%define name portal-unisinos
#Resumo do que é o pacote
%define summary Portal Unisinos
#Destino final da instalação do pacote
%define dest /var/www
#Branch de onde será feito o export do produto
%define branch http://parma.unisinos.br/repos/web/unisinos/portal/branches/portal
#Autor do pacote
%define author 'Felipe Barth'
#Define onde será feita a Build
%define buildroot /home/vagrant/rpm

Name: %{name}
Summary: %{summary} - Revision %{revision}
Vendor: ASAV/GTI
Release: %{release}
License: Proprietary
Group:   Desenvolvimento Web
Version: %{version}
Source: %{_rpmfilename}
BuildArch: noarch
Distribution: Proprietary
Prefix: %{dest}
BuildRoot: %{buildroot}

%description
Pacote %{name} para instalação no ambiente de Homologação
Gerado por %{author}
Branch %{branch} 
Revisão %{revision}
 
%build
rm -rf %{buildroot}/%{dest}
#php -f /home/fbarth/public_html/testerpm/email.php email.php %{name} %{version} %{author} %{branch} %{_rpmfilename}

%install
svn export %{branch} -r %{revision} --username fbarth --password XXXX --non-interactive %{buildroot}/%{dest}
 
%clean
rm -rf %{buildroot}/%{dest}
 
%files
%defattr (-,vagrant,users)
%{dest}
%config(noreplace) %attr(0644,vagrant,users) %{dest}/configuration.php
%config(noreplace) %attr(0644,vagrant,users) %{dest}/.htaccess
%config(noreplace) %{dest}/logs/*
%dir %attr(0755,vagrant,users) %{dest}/images
%dir %attr(0755,vagrant,users) %{dest}/logs
%exclude  %{dest}/node_modules.sh
%exclude  %{dest}/bower.json
%exclude  %{dest}/npm-debug.log
%exclude  %{dest}/gruntfile.js
%exclude  %{dest}/images/*

%post
# comando executados após a instalaçaõ do pacote
