<?php

namespace apps\common\entity;

/**
 * @Entity
 * @Table(name="dft_User")
 */
class User extends EntityBase {

    /**
     * @Id 
     * @Column(type="integer", length=11, name="Id")
     * @GeneratedValue
     */
    public $id;

    /** @Column(type="string", length=255, name="Name") */
    public $name;

    /** @Column(type="string", length=255, name="Surname") */
    public $surname;

    /** @Column(type="string", length=255, name="Username") */
    public $username;

    /** @Column(type="string", length=255, name="Password") */
    public $password;

    /** @Column(type="string", length=50, name="Role_Code") */
    public $roleCode;

    /** @Column(type="integer", length=11, name="LK_Department_Id") */
    public $departmentId;

    /** @Column(type="string", length=100, name="Email") */
    public $email;
    
    /** @Column(type="string", length=100, name="Telephone") */
    public $telephone;
    
    /** @Column(type="string", name="Address") */
    public $address;
	
	/** @Column(type="string", name="IsActive") */
    public $isActive;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getRoleCode() {
        return $this->roleCode;
    }

    function getDepartmentId() {
        return $this->departmentId;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getAddress() {
        return $this->address;
    }

	 function getIsActive() {
        return $this->isActive;
    }
	
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRoleCode($roleCode) {
        $this->roleCode = $roleCode;
    }

    function setDepartmentId($departmentId) {
        $this->departmentId = $departmentId;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setAddress($address) {
        $this->address = $address;
    }
	
	 function setIsActive($isActive) {
        $this->isActive = $isActive;
    }
}
